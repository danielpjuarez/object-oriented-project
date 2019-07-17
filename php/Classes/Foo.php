<?php
namespace\djuarez11\object-oriented-project;

/**
 * This table is an example of data collected and stored
 * about an author for the purpose of categorizing them
 */


require_once (dirname(__dir__)."/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class author {
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
	//convert and store the tweet id
	$this->authorId=$uuid;

}


}