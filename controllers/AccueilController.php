<?php 


Class AccueilController extends Controller {
	
	public function index()
	{
		$article= new Articles();
		$articles=$article->selectAllArticles(3);
		$this->set(['articles'=>$articles]);
		$this->render('index');
	}


	public function article(string $id): void 
	{
		if ($id) 
		{
			$article= new Articles();
			$article->id= (int)$id;
			$art=$article->selectArticle();
			$this->set(['article'=>$art]);
			$this->render('detailsArticle');
			die();
			
		}

		$this->articles();
		die();
	}

	public function articles(): void 
	{
		$article= new Articles();
		$articles=$article->selectAllArticles();
		$this->set(['articles'=>$articles]);
		$this->render('articles');
	}


	public function apropos(): void 
	{
		$this->render('apropos');
		die();

	}

	public function aide(): void 
	{
		$article= new Articles();
		$articles=$article->selectAllArticles(3);
		$this->set(['articles'=>$articles]);
		$this->render('aide');
		die();
	}


}
