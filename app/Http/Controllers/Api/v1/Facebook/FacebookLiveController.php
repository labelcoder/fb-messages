<?php

namespace App\Http\Controllers\Api\v1\Facebook;

use App\Customer;
use Carbon\Carbon;
use App\FacebookPost;
use App\FacebookComment;
use Illuminate\Http\Request;
use App\FacebookFetchHistory;
use App\Services\FacebookService;
use App\Http\Controllers\Controller;
use App\Libs\OrderLib;
use App\Product;
use PhpParser\Node\Stmt\TryCatch;

class FacebookLiveController extends Controller
{
    protected $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function fetchComments($videoId)
    {
        $response = ['success' => false, 'data' => [], 'message' => 'Error!'];

        try {
            list($userId, $postId) = explode('_', $videoId);

            $comments = $this->facebookService->getLiveComments($videoId);
            $postInfo = $this->facebookService->getPostInfo($videoId);
            $profile = $this->facebookService->getProfile($userId);

            if (isset($comments['error'])) {
                return response()->json(['error' => $comments['error']], 500);
            }

            $nowDateTime = Carbon::now()->format('Y-m-d H:i:s');
            $historyTimestamp = $nowTimestamp = Carbon::parse($nowDateTime)->timestamp;

            $history = FacebookFetchHistory::orderBy('fetch_time', 'desc')->first();
            $hasExists = false;
            if ($history) {
                $hasExists = true;
                $historyTimestamp = Carbon::parse($history->fetch_time)->timestamp;
            }

            $resultInsertHistory = FacebookFetchHistory::create([
                'fetch_time' => $nowDateTime,
                'post_id' => $videoId,
                'comments_fetched' => intval(0),
                'status' => 'done'
            ]);

            // get author 
            list($authorId, $postId) = explode('_', $postInfo['id']);

            $authorInfo = $this->facebookService->getPageProfile($authorId);
            $resultInsertPost = FacebookPost::create([
                'post_id' => $postId,
                'author_name' => $authorInfo['name'],
                'author_id' => $authorId,
                'content' => trim($postInfo['message']),
                'created_time' => Carbon::parse($postInfo['created_time'])->format('Y-m-d H:i:s'),
                'updated_time' => Carbon::parse($postInfo['created_time'])->format('Y-m-d H:i:s'),
                'like_count' => intval(0),
                'comment_count' => intval(0),
                'share_count' => intval(0),
            ]);

            $pattern = '/SKU-\d{5}/'; // for find sku create order
            $matchedSkus = [];
            foreach ($comments as $item) {
                $commentTimestamp = Carbon::parse(trim($item['created_time']))->timestamp;
                if ($commentTimestamp > $historyTimestamp) {
                    $resultComment = FacebookComment::create([
                        'comment_id' => $item['id'],
                        'post_id' => $postId,
                        'author_name' => $item['from']['name'],
                        'author_id' => $item['from']['id'],
                        'parent_comment_id' => $item['created_time'],
                        'content' => $item['message'],
                        'created_time' => $nowDateTime,
                        'updated_time' => $nowDateTime,
                        'like_count' => intval(0),
                    ]);
                    if (preg_match($pattern, $item['message'], $matches)) {
                        $matchedSkus[] = ['code' => $matches[0], 'facebook_id' => $item['from']['id']];
                    }
                } elseif (!$hasExists) {
                    $resultComment = FacebookComment::create([
                        'comment_id' => $item['id'],
                        'post_id' => $postId,
                        'author_name' => $item['from']['name'],
                        'author_id' => $item['from']['id'],
                        'parent_comment_id' => $item['created_time'],
                        'content' => $item['message'],
                        'created_time' => $nowDateTime,
                        'updated_time' => $nowDateTime,
                        'like_count' => intval(0),
                    ]);
                    if (preg_match($pattern, $item['message'], $matches)) {
                        $matchedSkus[] = ['code' => $matches[0], 'facebook_id' => $item['from']['id']];
                    }
                }
            }
            // check and create order
            if (count($matchedSkus) > 0) {
                foreach ($matchedSkus as $item) {
                    // check is customer
                    $customer = Customer::where('facebook_id', $item['facebook_id'])->first();
                    if (!$customer) {
                        $customerProfile = $this->facebookService->getProfile(trim($item['facebook_id']));
                        if ($customerProfile) {
                            $data = [
                                'first_name' => $customerProfile['first_name'],
                                'last_name' => $customerProfile['last_name'],
                                'email' => $item['facebook_id'].'@facebook.com',
                                'phone' => null,
                                'address' => 'Customer From Facebook',
                                'facebook_id' => $item['facebook_id'],
                                'line_id' => null
                            ];
                            $customer = OrderLib::createCustomer($data);
                        }
                    }

                    // create order
                    $product = Product::where('sku', trim($item['code']))->first();
                    $qty_numbers[$product->id] = intval(1);
                    $input = [
                        'customer_id' => $customer->id,
                        'item_ids' => [$product->id],
                        'qty_numbers' => $qty_numbers,
                        'address' => $customer->address,
                        'note' => 'Customer From Facebook'
                    ];
                    $response = OrderLib::placeOrders($input);
                }
            }
        } catch (\Exception $e) {
            //throw $th;
            $response = ['success' => false, 'data' => [], 'message' => $e->getMessage()];
        }

        // return response()->json(['comments' => $comments]);
        return response()->json($response, 200);
    }
}
