<?php
namespace djuarez11\objectorientedproject;

/**
 * This table is an example of data collected and stored
 * about an author for the purpose of categorizing them
 */


require_once(dirname(__DIR__)."/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class author implements \jsonSerialize {
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
public function getAuthorAvatarUrl() : ?string {
	return ($this->authorAvatarUrl);
}
/**
 *mutator method for authorAvatarUrl
 * @param string $newAuthorAvatarUrl new value of Author Avatar Url
 * @throws \InvalidArgumentException if $newProfileAvatarUrl is not a string or insecure
 * @throws \RangeException if $newProfileAvatarURl is > 255 characters
 */

public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
	$newAuthorAvatarUrl=trim($newAuthorAvatarUrl);
	$newAuthorAvatarUrl=filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_VALIDATE_URL);
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
			$this->ProfileActivationToken = null;
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
	if (empty($newAuthorEmail)===true) {
		throw(new\RangeException("author email empty or insecure"));

	//verify the email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("author email address is too large"));
		}
	//store the email
	$this->authorEmail=$newAuthorEmail;
	}
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
	 * @throws \RangeExceptionif authorUsername is >32 characters
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

		// create query template
		$query = "INSERT INTO Author(authorId,authorAvatarUrl, authorActivationToken, authorEmail, authorhash, authorUsername)
 	VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, authorHash)";
		$statement = $pdo->prepare($query);
	}

	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		$fields["authorAvatarUrl"] = $this->authorAvatarUrl->toString();
		$fields["authorActivationToken"] = $this->authorActivationToken->toString();
		$fields["authorEmail"] = $this->authorEmail->toString();
		$fields["authorHash"] = $this->authorHash->toString();
		$fields["authorUsername"] = $this->authorUsername->toString();

		return ($fields);
	}
}

