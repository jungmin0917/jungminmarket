<?php

namespace Controller\Front\Board;

use App;
use Component\Exception\AlertException;

class ModifyController extends \Controller\Front\FrontController{

	public function __construct(){
		$postNo = request()->get('post');

		$board = App::load(\Component\Board\Board::class);

		$data = $board->getPost($postNo);

		// 본인 확인
		if($data['memNm'] !== getSession('member_memNm')){
			alertBack('잘못된 접근입니다');
		}
	}

	public function index(){
		try{
			$boardId = request()->get('id');
			$postNo = request()->get('post');

			$board = App::load(\Component\Board\Board::class);

			$data = $board->getPost($postNo);
			
			// 임시 세션 처리 (다른 사람이 쿼리스트링 값 바꿔서 할 수 있으므로)
			setSession('board_postNo', $postNo);

			$boardNm = $board->getBoardNm($boardId);
			$data = $board->getPost($postNo);
			$data = array_merge($data, ['boardNm' => $boardNm]);

			$file = App::load(\Component\Core\File::class);

			// '이미지 추가' 란에 기존 이미지 등록하기 위해 이미지 파일 리스트 구함
			$imageList = $file->getImageList($data['fileGroup']);

			// 이미지 리스트 기존 데이터 배열에 합침
			$data = array_merge($data, ['imageList' => $imageList]);

			$skin = $board->getSkin($boardId);

			App::render("Front/Board/Skins/{$skin}/write", $data);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}