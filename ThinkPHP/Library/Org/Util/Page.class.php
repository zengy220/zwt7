<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 分页类
 * 使用方式:
 * $page = new Page();
 * $page->init(1000, 20);
 * $page->setNotActiveTemplate('<span> {a} </span>');
 * $page->setActiveTemplate('{a}');
 * echo $page->show();
 *
 *
 * @author 风居住的地方
 */
namespace Org\Util;
class Page {
	/**
	 * 总条数
	 */
	private $total;
	/**
	 * 每页大小
	 */
	private $pageSize;
	/**
	 * 总页数
	 */
	private $pageNum;
	/**
	 * 当前页
	 */
	public $page;
	/**
	 * 地址
	 */
	private $uri;
	/**
	 * 分页变量
	 */
	private $pageParam;
	/**
	 * LIMIT XX,XX
	 */
	public $limit;
	/**
	 * 数字分页显示
	 */
	private $listnum = 8;
	/**
	 * 分页显示模板
	 * 可用变量参数
	 * {total}   总数据条数
	 * {pagesize}  每页显示条数
	 * {start}   本页开始条数
	 * {end}    本页结束条数
	 * {pagenum}  共有多少页
	 * {frist}   首页
	 * {pre}    上一页
	 * {next}    下一页
	 * {last}    尾页
	 * {list}    数字分页
	 * {goto}    跳转按钮
	 */
	private $template = '{frist}{pre}{list}{next}{last}{goto}&nbsp;&nbsp;共{pagenum}页 / {total}条记录';
	
	/**
	 * 当前选中的分页链接模板
	 */
	private $activeTemplate = '&nbsp;<a class="btn btn-primary btn-mini on" ">{text}</a>&nbsp;';
	/**
	 * 未选中的分页链接模板
	 */
	private $notActiveTemplate = '&nbsp;<a class="btn btn-mini" href="{url}">{text}</a>&nbsp;';
	/**
	 * 显示文本设置
	 */
	private $config = array('frist' => '首页', 'pre' => '上一页', 'next' => '下一页', 'last' => '尾页');
	/**
	 * 初始化
	 * @param type $total    总条数
	 * @param type $pageSize  每页大小
	 * @param type $param    url附加参数
	 * @param type $pageParam  分页变量
	 */
	public function __construct($total, $pageSize, $param = '', $pageParam = 'page') {
		$this->total = intval($total);
		$this->pageSize = intval($pageSize);
		$this->pageParam = $pageParam;
		$this->uri = $this->geturi($param);
		$this->pageNum = ceil($this->total / $this->pageSize);
		$this->page = $this->setPage();
		$this->limit = $this->setlimit();
	}

	/**
	 * 设置分页模板
	 * @param type $template  模板配置
	 */
	public function setTemplate($template) {
		$this->template = $template;
	}

	/**
	 * 设置选中分页模板
	 * @param type $activeTemplate   模板配置
	 */
	public function setActiveTemplate($activeTemplate) {
		$this->activeTemplate = $activeTemplate;
	}

	/**
	 * 设置未选中分页模板
	 * @param type $notActiveTemplate  模板配置
	 */
	public function setNotActiveTemplate($notActiveTemplate) {
		$this->notActiveTemplate = $notActiveTemplate;
	}

	/**
	 * 返回分页
	 * @return type
	 */
	public function show() {
		return str_ireplace(array(
			'{total}',
			'{pagesize}',
			'{start}',
			'{end}',
			'{pagenum}',
			'{frist}',
			'{pre}',
			'{next}',
			'{last}',
			'{list}',
			'{goto}',
		), array(
			$this->total,
			$this->setPageSize(),
			$this->star(),
			$this->end(),
			$this->pageNum,
			$this->frist(),
			$this->prev(),
			$this->next(),
			$this->last(),
			$this->pagelist(),
//			$this->gopage(),
		), $this->template);
	}

	/**
	 * 获取limit起始数
	 * @return type
	 */
	public function getOffset() {
		return ($this->page - 1) * $this->pageSize;
	}

	/**
	 * 设置LIMIT
	 * @return type
	 */
	private function setlimit() {
		return array((int) (($this->page - 1) * $this->pageSize), (int) ($this->pageSize));
	}

	/**
	 * 获取limit
	 * @param type $args
	 * @return type
	 */
	public function __get($args) {
		if ($args == "limit") {
			return $this->limit;
		} else {
			return null;
		}
	}

	/**
	 * 初始化当前页
	 * @return int
	 */
	private function setPage() {
		if (!empty($_GET[$this->pageParam])) {
			if ($_GET[$this->pageParam] > 0) {
				if ($_GET[$this->pageParam] > $this->pageNum) {
					return $this->pageNum;
				} else {
					return $_GET[$this->pageParam];
				}

			}
		}
		return 1;
	}

	/**
	 * 初始化url
	 * @param type $param
	 * @return string
	 */
	private function geturi($param) {
		if(strpos($_SERVER['REQUEST_URI'], 'page')){
			$url = strchr($_SERVER['REQUEST_URI'],'/page',true) . $param;
		} else {
			$url = $_SERVER['REQUEST_URI'] . $param;
		}
		$parse = parse_url($url);
		if (isset($parse["query"])) {
			parse_str($parse["query"], $params);
			unset($params["page"]);
			$url = $parse["path"] . "?" . http_build_query($params);
			return $url;
		} else {
			return $url;
		}
	}

	/**
	 * 本页开始条数
	 * @return int
	 */
	private function star() {
		if ($this->total == 0) {
			return 0;
		} else {
			return ($this->page - 1) * $this->pageSize + 1;
		}
	}

	/**
	 * 本页结束条数
	 * @return type
	 */
	private function end() {
		return min($this->page * $this->pageSize, $this->total);
	}

	/**
	 * 设置当前页大小
	 * @return type
	 */
	private function setPageSize() {
		return $this->end() - $this->star() + 1;
	}

	/**
	 * 首页
	 * @return type
	 */
	private function frist() {
		$html = '';
		if ($this->page == 1) {
			$html .= $this->replace("{$this->uri}/page/1", $this->config['frist'], true);
		} else {
			$html .= $this->replace("{$this->uri}/page/1", $this->config['frist'], false);
		}
		return $html;
	}

	/**
	 * 上一页
	 * @return type
	 */
	private function prev() {
		$html = '';
		if ($this->page > 1) {
			$html .= $this->replace($this->uri . '/page/' . ($this->page - 1), $this->config['pre'], false);
		} else {
			$html .= $this->replace($this->uri . '/page/' . ($this->page - 1), $this->config['pre'], true);
		}
		return $html;
	}

	/**
	 * 分页数字列表
	 * @return type
	 */
	private function pagelist() {
		$linkpage = "";
		$lastlist = floor($this->listnum / 2);
		for ($i = $lastlist; $i >= 1; $i--) {
			$page = $this->page - $i;
			if ($page >= 1) {
				$linkpage .= $this->replace("{$this->uri}/page/{$page}", $page, false);
			} else {
				continue;
			}
		}
		$linkpage .= $this->replace("{$this->uri}/page/{$this->page}", $this->page, true);
		for ($i = 1; $i <= $lastlist; $i++) {
			$page = $this->page + $i;
			if ($page <= $this->pageNum) {
				$linkpage .= $this->replace("{$this->uri}/page/{$page}", $page, false);
			} else {
				break;
			}
		}
		return $linkpage;
	}

	/**
	 * 下一页
	 * @return type
	 */
	private function next() {
		$html = '';
		if ($this->page < $this->pageNum) {
			$html .= $this->replace($this->uri . '/page/' . ($this->page + 1), $this->config['next'], false);
		} else {
			$html .= $this->replace($this->uri . '/page/' . ($this->page + 1), $this->config['next'], true);
		}
		return $html;
	}

	/**
	 * 最后一页
	 * @return type
	 */
	private function last() {
		$html = '';
		if ($this->page == $this->pageNum) {
			$html .= $this->replace($this->uri . '/page/' . ($this->pageNum), $this->config['last'], true);
		} else {
			$html .= $this->replace($this->uri . '/page/' . ($this->pageNum), $this->config['last'], false);
		}
		return $html;
	}

	/**
	 * 跳转按钮
	 * @return string
	 */
	private function gopage() {
		$html = '';
		$html .= ' <input type="text"  value=""  onkeydown="javascript:if(event.keyCode==13){var page=(this.value>' . $this->pageNum . ')?' . $this->pageNum . ':this.value;location=\'' . $this->uri . '/page/\'+page+\'\'}" style="width:25px;height:16px;margin-bottom:0;"/>
		<input type="button" onclick="javascript:var page=(this.previousSibling.value>' . $this->pageNum . ')?' . $this->pageNum . ':this.previousSibling.value;location=\'' . $this->uri . '/page/\'+page+\'\'" value="GO"/>';
		return $html;
	}

	/**
	 * 模板替换
	 * @param type $replace   替换内容
	 * @param type $result   条件
	 * @return type
	 */
	private function replace($url, $text, $result = true) {
		$template = ($result ? $this->activeTemplate : $this->notActiveTemplate);

		$html = str_replace('{url}', $url, $template);
		$html = str_replace('{text}', $text, $html);
		return $html;
	}
}