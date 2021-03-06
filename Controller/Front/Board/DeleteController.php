<?php

namespace Controller\Front\Board;

use App;

class DeleteController extends \Controller\Front\FrontController{
	public function __construct(){
		$this->layoutBlank = true;

		$postNo = request()->get('post');

		$board = App::load(\Component\Board\Board::class);

		$data = $board->getPost($postNo);

		// 관리자가 아닌 경우 본인 확인 진행
		if(getSession('member_memLv') != 10){
			if($data['memNm'] !== getSession('member_memNm')){
				alertBack('잘못된 접근입니다');
			}
		}
	}

	public function index(){
		try{
			$boardId = request()->get('id');
			$postNo = request()->get('post');
			$board = App::load(\Component\Board\Board::class);

			$postData = $board->getPost($postNo);

			// DB에서 게시글 삭제
			$result = $board->deletePost($postNo);

			if($result === false){
				throw new AlertException('게시글 삭제 실패');
			}

			// 실제 업로드 파일 삭제
			$file = App::load(\Component\Core\File::class);

			$result = $file->deleteFiles($postData['fileGroup']);

			if($result === false){
				throw new AlertException('파일 삭제 실패');
			}

			alertGo("게시글 삭제에 성공했습니다. 게시글 목록으로 돌아갑니다", "board/list?id={$boardId}");

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}