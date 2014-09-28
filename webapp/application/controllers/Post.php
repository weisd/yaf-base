<?php
/**
 * post
 */
class PostController extends BaseController {
	/**
	 * index
	 * @return [type] [description]
	 */
	public function indexAction() {
		$post = new PostModel();
		$list = $post->select('*');

		$this->_view->assign(compact('list'));
	}

	/**
	 * add
	 */
	public function addAction() {
		if ($this->getRequest()->getMethod() === 'POST') {
			$title = $this->_request->getPost('title', '');
			$content = $this->_request->getPost('content', '');

			if (empty($title) || empty($content)) {
				$this->redirect('/post/add');
				return;
			}
			// @todo 验证 && 过滤

			$post = new PostModel();
			$id = $post->insert(compact('title', 'content'));

			if ($id) {
				// 成功跳转
				$this->redirect('/post/index');
				return;
			}

			// @todo错误提示
			var_dump($post->error());
		}
	}

	/**
	 * save
	 */
	public function editAction($id = '') {
		if (empty(intval($id))) {
			// @todo错误提示跳转
			$this->redirect('/psot/index');
		}

		// @tode 权限

		$post = new PostModel();
		$info = $post->get('*', ['id'=>$id]);

		if (empty($info)) {
			// @todo error notice
			$this->redirect('/post/index');
		}


		if ($this->getRequest()->getMethod() === 'POST') {
			$title = $this->_request->getPost('title', '');
			$content = $this->_request->getPost('content', '');
			if (empty($title) || empty($content)) {
				$this->redirect('/post/edit');
				return;
			}
			// @todo 验证 && 过滤
			 
			$post->update(compact('title', 'content'), ['id'=>$id]);

			// notice success
			$this->redirect('/post/index');
		}

		
		$this->_view->assign(compact('info'));
	}

	public function delAction($id='')
	{
		// @todo 权限过滤
		$post = new PostModel();
		var_dump($id);
		$res = $post->delete(['id'=>$id]);
		$this->redirect('/post/index');
	}

}