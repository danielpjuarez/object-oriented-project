<?php
namespace djuarez11\objectorientedproject;

/**
 * This table is an example of data collected and stored
 * about an author for the purpose of categorizing them
 */

require_once "autoload.php";
require_once(dirname(__DIR__)."/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class author implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 *id for this Author, primary key, obviously a required value
	 **/
	private $authorId;
	/**
	 *This is the URL for the author's avatar, whatever that is
	 */
	private $authorAvatarUrl;
	/**
	 * this is the author's activation token. In this context I don't know
	 * what it is supposed to do
	 */
	private $authorActivationToken;
	/**
	 * this is the author's email, and it is required and unique
	 */
	private $authorEmail;
	/**
	 * this is the author's hash, and is required
	 */
	private $authorHash;
	/**
	 * this is the author's username, and is required and unique
	 */
	private $authorUsername;

	/**constructor for this author
	 *@param string|Uuid $newAuthorId id of this author or null if new author
	 *@param string|Uuid $newAuthorAvatarUrl id of the author's avatar URL
	 *@param string $newAuthorActivationToken string containing author's activation token
	 *@param string $newAuthorEmail string containing author's email address
	 *@param string $newAuthorHash string containing author's hash
	 *@param string $newAuthorUsername string containing author's username
	 *@throws \InvalidArgumentException if data types are not valid
	 *@throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if there is another exception
	**/

	public function __construct($newAuthorId, $newAuthorAvatarUrl, $newAuthorActivationToken,
	$newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
				$this->setAuthorID($newAuthorId);
				$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
				$this->setAuthorActivationToken($newAuthorActivationToken);
				$this->setAuthorEmail($newAuthorEmail);
				$this->setAuthorHash($newAuthorHash);
				$this->setAuthorUsername($newAuthorUsername);
			}
			//determining what exception type is thrown, if any
			catch(\invalidArgumentException|\RangeException|\Exception|\TypeError $exception) {
				$exceptionType=get_class($exception);
				throw(new $exceptionType($exception->getMessage(),0,$exception));
			}

	}

	/**
	 *accessor method for author id
	 * @return Uuid value of author id
	 */
	public function getAuthorId():Uuid{
		return($this->authorId);
	}

	/**
	 * mutator method for author id
	 * @param Uuid|string $newAuthorId new value of author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if $newAuthorId is not a uuid or string
	 */
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid =self::validateUuid($newAuthorId);
		} catch (\invalidArgumentException |\RangeException|\Exception|\TypeError $exception) {
			$exceptionType=get_class($exception);
			throw(new$exceptionType($exception->getMessage(),0, $exception));
		}
		//convert and store the author id
		$this->authorId=$uuid;
	}
/**
 * accessor method for authorAvatarUrl
 * @return string value of activationAuthorUrl
 */
	public function getAuthorAvatarUrl() : string {
		return ($this->authorAvatarUrl);
	}
/**
 *mutator method for authorAvatarUrl
 * @param string $newAuthorAvatarUrl new value of Author Avatar Url
 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a string or insecure
 * @throws \RangeException if $newAuthorAvatarURl is > 255 characters
 * @throws \TypeError if $newAtHandle is not a  string
 */

	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl) : void {

		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify the avatar URL will fit in database
		if(strlen($newAuthorAvatarUrl)>255){
			throw(new \RangeException("image cloudinary content too large"));
		}
		//store the image cloudinary content
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
}
	/**
	 * accessor method for authorActivationToken
	 * @return string value of authorActivationToken
	 */
	public function getAuthorActivationToken() : ?string {
		return ($this->authorActivationToken);
	}
	/**
	 *mutator method for authorActivationToken
	 * @param string $newAuthorActivationToken new value of Author Avatar Url
	 * @throws \InvalidArgumentException if $newAuthorActivationToken is not a string or insecure
	 * @throws \RangeException if $newAuthorActivationToken is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */

	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		if ($newAuthorActivationToken ===null) {
			$this->AuthorActivationToken = null;
			return;
		}
		if(ctype_xdigit ($newAuthorActivationToken) ===false) {
			throw (new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newAuthorActivationToken) !==32) {
			throw(new\RangeException("user activation token has to be 32 characters"));
		}
		$this->authorActivationToken=$newAuthorActivationToken;
}

	/**
	 * This is the accessor method for authorEmail.
	 * @return string value of email
	 */
	public function getAuthorEmail(): string {
		return $this->AuthorEmail;
	}

	/**
	 * mutator method for authorEmail
	 * @param string $newAuthorEmail new value of authorEmail
	 * @throws \InvalidArgumentException if $newAuthorEmail is not a valid email or insecure
	 * @throws \RangeException if $newAuthorEmail is >128 characters
	 * @throws \TypeError if $newAuthorEmail is not a string
	 */

	public function setAuthorEmail (string $newAuthorEmail): void {
		//verify email is secure
		$newAuthorEmail=trim($newAuthorEmail);
		$newAuthorEmail=filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if (empty($newAuthorEmail) === true) {
			throw(new\InvalidArgumentException("author email empty or insecure"));
		}
		//verify the email will fit in the database
			if(strlen($newAuthorEmail) > 128) {
				throw(new \RangeException("author email address is too large"));
			}

		//store the mmial
		$this->authorEmail=$newAuthorEmail;

	}

	/**
	 * This is the accessor method for authorHash
	 * @return string value of authorHash
	 */
	public function getAuthorHash (): string {
		return $this->authorHash;
	}

	/**
	 * This is the mutator method for authorHash
	 * @param string $newAuthorHash new value of authorHash
	 * @throws \InvalidArgumentException if hash is not secure
	 * @throws \RangeException if the authorHash is not 128 characters
	 * @throws \TypeError if authorHash is not a string
	 */

	public function setAuthorHash($newAuthorHash): void {
	//enforce that the hash is properly formatted
		$newAuthorHash= trim($newAuthorHash);
		if(empty($newAuthorHash)===true){
			throw(new\InvalidArgumentException("profile password hash empty or insecure"));
			}

		//enforce the has is an Argon hash
		$authorHashInfo=password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !=="argon2i")

		 {
				throw(new \InvalidArgumentException("profile hash is not a valid hash"));
			}

		//enforce that the hash is exactly 97 characters
		if(strlen($newAuthorHash)!==97) {
			throw(new \RangeException("profile hash must be 97 characters"));
		}
		//store the hash
			$this->authorHash=$newAuthorHash;
		}
	/**
	 *@return authorHash from password
	 */

	/**
	 * accessor method for authorUsername
	 * @return string authorUsername
	 */
	/**
	 * @return mixed
	 */
	public function getAuthorUsername(): string {
		return $this->authorUsername;
	}

	/**
	 * mutator method for authorUsername
	 * @param string $newAuthorUsername new value of authorUsername
	 * @throws \invalidArgumentException if authorUsername is not secure or is null
	 * @throws \typeError if authorUsername is not a string
	 * @throws \RangeException if authorUsername is >32 characters
	 */

	/**
	 * @param mixed $authorUsername
	 */
	public function setAuthorUsername(?string $newauthorUsername): void {
		//if $AuthorUsername is null
		if($newauthorUsername===null){
			$this->authorUsername=null;
			return;
		}

		//verify the username is secure
		$newauthorUsername=trim($newauthorUsername);
		$newauthorUsername=filter_var($newauthorUsername, FILTER_SANITIZE_STRING);
		if(empty($newauthorUsername)===true){
			throw(new\InvalidArgumentException("author username is empty or insecure"));
		}

		//verify the username will fit in the database
		if(strlen($newauthorUsername)>32) {
			throw(new\InvalidArgumentException("username is too long"));
		}

		//store the username
		$this->authorUsername=$newauthorUsername;
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/

	/**
	 * inserts this Author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// template for query
		$query = "INSERT INTO Author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername)
 		VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, authorHash)";
		$statement = $pdo->prepare($query);
		//this binds the member variables to the placeholders in the template. note to self:
		//"getBytes" converts string into bytes
		$parameters= ["authorId"=>$this->authorId->getBytes(),
			"authorAvatarUrl"=>$this->authorAvatarUrl->getBytes(),
			"authorActivationToken"=>$this->authorActivationToken->getBytes(),
			"authorEmail"=>$this->authorEmail->getBytes(),
			"authorHash"=>$this->authorHash->getBytes(),
			"authorUsername"=>$this->authorUsername->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * template for updating an author in sql
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
	//this part is a query template to select values to be changed
		$query= "UPDATE author SET authorProfileId=:authorProfileId, 
		authorAvatarUrl=:authorAvatarUrl
		authorActivationToken=:authorActivationToken, 
		authorEmail=:authorEmail,
		authorHash=:authorHash, 
		authorUsername=:authorUsername";
	$statement=$pdo->prepare($query);
	}

	/**
	 * deletes author from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete (\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM author WHERE authorId=:authorId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the placeholder in the template
		$parameters = ["authorId"=>$this->authorId->getBytes()];
		$statement->execute($parameters);
		}

	/**
	 * this is a method to get author by author ID
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author ID to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDO exception when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 */
	public static function getAuthorbyAuthorID (\PDO $pdo, $authorId) : ?Author {
		/**
		*sanitize the authorId before searching. Don't worry, Uuids can be safely
		 * sanitized because they aare supposed to be just alphanumeric characters
		*/
		try{
			$authorId =self::validateUuid($authorId);
			}
			catch (\InvalidArgumentException|\RangeException|\Exception|\TypeError $exception) {
				throw(new\PDOException ($exception->getMessage(),0,$exception));
			}
		//create query template
		$query = "select authorId, authorAvatarUrl, authorEmail, 
		authorHash, authorActivationToken, authorUsername FROM author WHERE authorId= :authorId";
		$statement = $pdo->prepare ($query);

		//bind the author id to the placeholder in the template
		$parameters= ["authorId"=>$authorId->getBytes()];
		$statement->execute($parameters);

		//grab the author from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new Author($row["authorId"], $row[authorAvatarUrl], $row[authorEmail],
					$row[authorHash], $row[authorActivationToken], $row [authorUsername]);
			}
		}catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
			throw (new\PDOException($exception->getMessage(),0,$exception));
			}
		return ($author);
		}

	/**
	 *this method will return an full array of authors
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Authors found or null if not found
	 * @throws \PDOExceptionwhen mySQL related errors occur
	 * @throws \TypeErrorwhen varaibles are not the correct data type
	 */
	public static function getAllAuthors (\PDO $pdo): \SPLFixedArray {
		//create query template
		$query = "select authorId, authorAvatarUrl, authorEmail, 
		authorHash, authorActivationToken, authorUsername FROM author";
		$statement =$pdo ->prepare ($query);
		$statement ->execute ();

		//build an array of authors
		$authors =new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode((\PDO::FETCH_ASSOC));
		while (($row=$statement->fetch())!==false) {
			try {
				$author = new author ($row["authorId"], $row[authorAvatarUrl], $row[authorEmail],
					$row[authorHash], $row[authorActivationToken], $row [authorUsername] );
					$author[$author->key()]=$author;
					$author->next();
			}
			catch(\Exception$exception){
				//if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(),0, $exception));
			}
		return ($authors);
		}
	}
/*
 * formats state variables for JSON serialization
 * @return array resulting state variables to serialize
 */
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);
		$fields["authorId"] = $this->authorId->toString();

		return ($fields);
	}

}
