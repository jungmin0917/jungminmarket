<?php

namespace Component\Core;

use App;

class Pagination{

	private $page;
	private $limit;
	private $total;
	private $url;
	private $pageLinks;
	private $lastPageNo;
	private $pageLinksSection;
	private $sectionStartNo;
	private $sectionLastNo;
	private $nextSectionStartNo;
	private $prevSectionStartNo;
	private $lastPageLinksSection;

	public function __construct($page = 1, $limit, $total, $url){
		$this->page = $page = $page?$page:1;
		$this->limit = $limit = $limit?$limit:10;
		$this->total = $total;
		$this->pageLinks = $pageLinks = 5;
		$this->lastPageNo = $lastPageNo = ceil($total / $limit);
		$this->pageLinksSection = $pageLinksSection = floor(($page - 1) / $pageLinks);
		$this->sectionStartNo = $sectionStartNo = ($pageLinksSection * $pageLinks) + 1;
		$this->sectionLastNo = $sectionLastNo = ($pageLinksSection + 1) * $pageLinks;
		$this->nextSectionStartNo = $sectionStartNo + $pageLinks;
		$this->prevSectionStartNo = $sectionStartNo - $pageLinks;
		$this->lastPageLinksSection = floor(($lastPageNo - 1) / $pageLinks);

		if($lastPageNo < $sectionLastNo){
			$sectionLastNo = $lastPageNo;
		}

		$this->sectionLastNo = $sectionLastNo;

		// url 처리
		if($url){
			if(strpos($url, '?')){
				$url .= "&";
			}else{
				$url .= "?";
			}
		}

		$this->url = $url;
	}

	public function getHTML(){
		$html = "<ul class='pagination'>";

		if($this->pageLinksSection > 0){
			$html .= "<li class='page_first'><a href='{$this->url}page=1'>처음</a></li>";
		}

		if($this->pageLinksSection > 0){
			$html .= "<li class='page_prev'><a href='{$this->url}page={$this->prevSectionStartNo}'>이전</a></li>";
		}

		for($i=$this->sectionStartNo; $i<=$this->sectionLastNo; $i++){
			if($i == $this->page){
				$addClass = ' on';
			}else{
				$addClass = '';
			}
			$html .= "<li class='page{$addClass}'><a href='{$this->url}page={$i}'>{$i}</a></li>";
		}

		if($this->pageLinksSection < $this->lastPageLinksSection){
			$html .= "<li class='page_next'><a href='{$this->url}page={$this->nextSectionStartNo}'>다음</a></li>";
		}

		if($this->pageLinksSection < $this->lastPageLinksSection){
			$html .= "<li class='page_last'><a href='{$this->url}page={$this->lastPageNo}'>마지막</a></li>";
		}

		$html .= "</ul>";

		return $html;
	}
}