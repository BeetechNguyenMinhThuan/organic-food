<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $comments = $this->productService->getProductReviewPaginate();
        return view('backend.comments.index', [
            'comments' => $comments
        ]);
    }

    public function changeStatusComment($productId, $commentId)
    {
        DB::beginTransaction();
        try {
            $this->productService->changeStatusComment($productId, $commentId);
            DB::commit();
            return redirect()->route('admin.comment.index')->with([
                'status_succeed' => "Đổi trạng thái thành công"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return redirect()->route('admin.comment.index')->with([
                'status_failed' => trans('messages.server_error')
            ]);
        }
    }
    public function adminReplyComment(Request $request, $productId, $commentId){
        DB::beginTransaction();
        try {
            $this->productService->adminReplyComment($request, $productId, $commentId);
            DB::commit();
            return redirect()->route('admin.comment.index')->with([
                'status_succeed' => "Phản hồi bình luận thành công"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return redirect()->route('admin.comment.index')->with([
                'status_failed' => trans('messages.server_error')
            ]);
        }
    }

    public function deleteComment($productId, $commentId){
        $commentDelete = $this->productService->deleteComment($productId, $commentId);
        if ($commentDelete) {
            return response()->json(['status' => 200, 'message' => "Success"]);
        }
        return response()->json(['status' => 500, 'message' => "Fail"], 500);
    }
}
