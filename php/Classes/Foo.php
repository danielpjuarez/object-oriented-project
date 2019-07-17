<?php
/**
 * This table is an example of data collected and stored
 * about an author for the purpose of categorizing them
 */

namespace\djuarez11\object-oriented-project;

use Ramsey\Uuid\Uuid;

class author {
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


	/**
	 * Now to create the accessor method for authorId. Should either pull an existing Uuid or return null
	 * in the absence of an existing profile
	 **/

	public function getAuthorId() {
		return ($this->authorId);
	}

	/**
	 *Below I will set the mutator method for creating a new authorId. There are a few requirements for creating
	 * a new authorId.
	 * the @param int $newAuthorId new value of authorId
	 * @throws UnexpectedValueException if $authorId is not an integer
	 *
	 **/

	public function setAuthorId($newAuthorId) {
	}
}
