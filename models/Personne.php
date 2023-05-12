<?php 

Class Personne extends Model {

	public $id; 
	public $prenom; 
	public $nom;
	public $sexe;
	public $date_de_naissance;
	public $mail;
	public $pseudo;
	public $password;  
	public $cree_le;
	public $id_adresse;

	public $mot_de_passe;
	public $adresse;
	public $note;
	private const PER_PAGE=3;




	public function __construct(string $prenom=null, string $nom=null, string $sexe=null, $date_de_naissance=null, string $password=null)
	{
		if ($prenom && $nom && $sexe && $date_de_naissance) {

			$this->prenom= $prenom;
			$this->nom= $nom;
			$this->sexe= $sexe;	
			$this->date_de_naissance=$date_de_naissance;
			$this->mot_de_passe= $password;	
		}
	
	}

	public function getPrenom(): ?string 
	{
		return $this->prenom;
	}

	public function getNom(): ?string 
	{
		return $this->nom;
	}

	public function getSexe(): ?string 
	{
		return $this->sexe;
	}

	public function getDateDeNaissance()
	{
		return $this->date_de_naissance;
	}

	public function getMail(): ?string 
	{
		return $this->mail;
	}

	public function getPseudo(): ?string 
	{
		return $this->pseudo;
	}

	public function getCreeLe(): string
	{
		return $this->cree_le;
	}

	public function getPassword(): ?string 
	{
		return $this->password;
	}
	public function getMotDePasse(): ?string 
	{
		return $this->mot_de_passe;
	}
	

	public function setId(string $id): void
	{
		$this->id=$id;
	}

	public function setPrenom(string $prenom): void
	{
		$this->prenom=$prenom;
	}

	public function setNom(string $nom): void 
	{
		$this->nom=$nom;
	}

	public function setMail(string $mail): void
	{
		$this->mail=$mail;
	}

	public function setPseudo(string $pseudo): void
	{
		$this->pseudo=$pseudo;
	}

	public function setMotDePasse(string $motDePasse): void
	{
		$this->mot_de_passe=$motDePasse;
	}

	public function setPassword(string $password): void
	{
		$this->password=$password;
	}

	public function setIdAdresse(string $id_adresse): void
	{
		$this->id_adresse=$id_adresse;
	}

	public function setCreeLe(string $cree_le): void
	{
		$this->cree_le=$cree_le;
	}

	public function setDateDeNaissance(string $date_de_naissance): void
	{
		$this->date_de_naissance=$date_de_naissance;
	}



	public function isPersonne(int $id=null): ?Personne
	{
		$pseudo= $this->pseudo; 
			
		$db=self::getPDO();

		if ($db) {
			
			if ($id) {

			$query= $db->prepare('SELECT * FROM personne WHERE id=:id');
			$query->execute([
			':id'=>$id
			]);
				
			}else{
				$query= $db->prepare('SELECT * FROM personne WHERE pseudo=:pseudo');
				$query->execute([
				':pseudo'=>$pseudo
				]);
			}
			
			$query->setFetchMode(PDO::FETCH_CLASS, Personne::class);
			$personne=$query->fetch();
			if ($personne === false) {
				return null;
			}
			return $personne;
		}

		return null;
		
	}



	public function personneLogin(): ?Personne
	{
		$personne=$this->isPersonne();

		if ($personne === null)
		{
			return null;
		}
		
		if (!password_verify($this->mot_de_passe, $personne->password))
		{
			return null;
		}
		return $personne;		
	}



	public function personneExist(): ?array 
	{
			$prenom= $this->prenom; 
			$nom= $this->nom;
			$sexe= $this->sexe;
			$date_de_naissance= date('Y-m-d', $this->date_de_naissance);
			$password= $this->mot_de_passe;


		$db=self::getPDO();
		$query= $db->prepare('SELECT * FROM personne WHERE prenom=:prenom AND nom=:nom AND sexe=:sexe AND date_de_naissance= :date_de_naissance');
		$query->execute([
			':prenom'=>$prenom,
			':nom' => $nom, 
			':sexe'=>$sexe,
			':date_de_naissance'=> $date_de_naissance
		]);
		$query->setFetchMode(PDO::FETCH_CLASS, Personne::class, [$prenom, $nom, $sexe, $date_de_naissance, $password]);
		$personne=$query->fetchAll();
		if ($personne === false) {
			return null;
		}
		return $personne;
	}

	public function completerPersonne(string $mail=null, string $password=null, string $pseudo=null, array $adresse=null): void
	{
		$this->mail= trim($mail);
		$this->password= trim($password);
		$this->pseudo= trim($pseudo);
		$this->adresse=$adresse;

	}

	public function verifyName(): bool
	{
		if (strlen($this->nom) < 3 || strlen($this->prenom) < 3 ) {
			return false;
		}
		$nom = explode(' ', $this->nom);
		$prenom= explode(' ', $this->prenom);

		foreach ($nom as $n) 
		{
			if (!ctype_alpha($n)) 
			{
			return false;
			exit();
			}
			
		}

		foreach ($prenom as $p) 
		{
			if (!ctype_alpha($p)) 
			{
			return false;
			exit();
			}
			
		}
		return true;
	}

	public function verifySexe(): bool 
	{
		if ($this->sexe !== 'homme' && $this->sexe !== 'femme' ) {
			return false;
		}
		return true;
	}

	public function verifyBirthDay(): bool 
	{
		if ($this->date_de_naissance === false || date("Y", $this->date_de_naissance) > date('Y')) {
			return false;
		}

		return true;
	}

	public function verifyPassword(): bool
	{
		if (!preg_match('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,20})$#', $this->password))
		{
			return false;
		}else {
			return true;
		}
	}

	public function verifyMail(): bool
	{
		if (!filter_var($this->mail, FILTER_VALIDATE_EMAIL))
		{
			return false;
		}else {
			return true;
		}
	}

	public function verifyPseudo(): bool 
	{
		if (!preg_match('#^[a-zA-Z]+([a-zA-Z]|[0-9]){4,15}$#', $this->pseudo))
        {
            return false;
        }
        return true;
	}


	public function verifyPseudoExist(): bool
	{
		$db=self::getPDO();
		$query= $db->prepare('SELECT * FROM personne WHERE pseudo=:pseudo');
		$query->execute([
			':pseudo'=>$this->pseudo
		]);
		$pseudo=$query->fetch();
		if ($pseudo) 
		{
			return false;
		}
		return true;
	}

	public function verifyAdresse(): bool
	{
		$typeVoie=['Rue', 'Boulevard', 'Chemin', 'Route', 'Impasse', 'Avenue'];
		
		if (!is_int($this->adresse['numero_voie'])) {
			return false;
		}
		if (!in_array($this->adresse['type_voie'], $typeVoie)) {
			return false;
		}
		if (!preg_match('#^[a-zA-Z]+([a-zA-Z|\s]){3,150}$#', $this->adresse['nom_voie'])) {
			return false;
		}
		if (!preg_match('#^([a-zA-Z0-9]+([a-zA-Z|\s|0-9]){0,255})*$#', $this->adresse['complement_adresse'])) {
			return false;
		}
		if (!preg_match('#^[a-zA-Z]+([a-zA-Z|\s|-]){3,255}$#', $this->adresse['ville'])) {
			return false;
		}
		if (!is_int($this->adresse['code_postal']) || $this->adresse['code_postal'] < 0 || $this->adresse['code_postal'] > 99999 ) {
			return false;
		}

		return true;
	}



	public function insertPersonne(): ?int
	{
		$password= password_hash($this->password, PASSWORD_DEFAULT);
		try{ 
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO personne (prenom, nom, sexe, date_de_naissance, mail, pseudo, password, cree_le, id_adresse) VALUES (:prenom, :nom, :sexe, :date_de_naissance, :mail, :pseudo, :password, :cree_le, :id_adresse)');
			$query->execute([
				':prenom'=>$this->prenom, 
				':nom'=>$this->nom, 
				':sexe'=>$this->sexe, 
				':date_de_naissance'=>$this->date_de_naissance, 
				':mail'=>$this->mail, 
				':pseudo'=>$this->pseudo, 
				':password'=>$password, 
				':cree_le'=>$this->cree_le, 
				':id_adresse'=>$this->id_adresse
			]);
			$personne=$query->rowCount();
				
			if ($personne > 0) 
			{
				$lastId=$db->lastInsertId();
				return (int)$lastId;
			}

			return null;
		}catch(Exception $e){
			$erreur=$e->getMessage();
			/*var_dump($erreur);
			die();
*/			return null; 
		}
		
	}

	public function queryCount(string $table, string $condition=null, array $parametre=null):?array
	{
		$queryCount= "SELECT COUNT('id') as count FROM ".$table; 
		if ($condition) {
			$queryCount.= $condition;
		}

		//requete sur le nombre de ligne:
		try{

			$pdo=self::getPDO();
			$statement= $pdo->prepare($queryCount);
			$statement->execute($parametre);
			$count=(int)$statement->fetch()['count'];
			$nbPages=ceil($count / self::PER_PAGE);

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null; 
		}
		$pages['nbrPersonne']=$count;
		$pages['pages']=$nbPages;
		return $pages;
		
	}

	public function selectAll(int $pageOffset, string $table, string $condition=null, array $params= null): array
	{	
		
		$personnes=[];
		$q="SELECT * FROM ".$table;

		if ($condition) {
			$q.= $condition;
		}

		$pageOffset= abs($pageOffset) ?? 1;
		$offset= ($pageOffset-1) * self::PER_PAGE;
		$q.=" LIMIT ". self::PER_PAGE . " OFFSET ".$offset;
	
		try {

			$db=self::getPDO();
			$query= $db->prepare($q);
			$query->execute($params);
		/*$query->setFetchMode(PDO::FETCH_CLASS, Personne::class, [null, null, null, null]);*/
			$personnes['reponse']=$query->fetchAll();

		}catch(Exception $e){
			$personnes['erreur']=$e->getMessage();

		}
		
		if (!$personnes['reponse']) {
			$personnes['vide']="Aucune personne trouvé";
		}
		 return $personnes;

	}


	public function alterPersonne():bool
	{
		$q='UPDATE personne SET prenom=:prenom, nom=:nom, sexe=:sexe, date_de_naissance= :date_de_naissance, mail=:mail, pseudo=:pseudo';

		$params=[
			':prenom'=>$this->prenom, 
			':nom'=>$this->nom, 
			':sexe'=>$this->sexe, 
			':date_de_naissance'=>date('Y-m-d', $this->date_de_naissance), 
			':mail'=>$this->mail, 
			':pseudo'=>$this->pseudo 
		    ];

		if ($this->password !== null) {
			$password= password_hash($this->password, PASSWORD_DEFAULT);
			$q.=', password=:password';
			$params[':password']=$password;
		}

		try{
			$q.=' WHERE id=:id';
			$params[':id']= (int)($this->id);
			$db=self::getPDO();
			$query= $db->prepare($q);
			$query->execute($params);
			$req=$query->rowCount();
			if ($req== 0) {
				return false;
			}
			return true;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}
	}

	public function deletePersonne():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM personne WHERE id=:id');
			$query->execute([
			':id'=>$this->id
			]);
			$req=$query->rowCount();
			if ($req== 0) {
				return false;
			}
			return true;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}
	}

	public function get_note(int $id_qcm): ?Note_eleve
	{
		try {
			
			$db=self::getPDO();

			$query= $db->prepare('SELECT note_eleve.* FROM note_eleve INNER JOIN eleve ON note_eleve.id_eleve=eleve.id_personne INNER JOIN qcm ON note_eleve.id_qcm=qcm.id WHERE note_eleve.id_eleve=:id_eleve AND note_eleve.id_qcm=:id_qcm');
			$query->execute([
				':id_eleve'=>$this->id,
				'id_qcm'=>$id_qcm
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Note_eleve::class);
			$note_eleve=$query->fetch();
			if ($note_eleve) 
			{
				$this->note=$note_eleve;
				return $note_eleve;
			}
			return null;
			
			
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}

	}


	
	
}