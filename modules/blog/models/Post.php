<?php namespace Blog;

use URL;
use Eloquent;
use ExpressiveDate;

class Post extends Eloquent {

	/**
	 * The model's table name.
	 *
	 * @var string
	 */
	public $table = 'posts';

	/**
	 * The model's validation rules.
	 *
	 * @var array
	 */
	public $rules = array(
		'author_id'        => array('required', 'numeric'),
		'title'            => array('required'),
		'content'          => array('required'),
		'comments_enabled' => array('integer'),
	);

	/**
	 * Wether the table keeps track of timestamps.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Get the post's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Get the post's comments.
	 *
	 * @return array
	 */
	public function comments()
	{
		return $this->hasMany('Blog\Comment');
	}

	/**
	 * Get the date the post was created.
	 *
	 * @return string
	 */ 
	public function date()
	{
		return ExpressiveDate::make($this->attributes['created_at'])->getRelativeDate();
	}

	/**
	 * Get the URL to the post.
	 *
	 * @return string
	 */
	public function url()
	{
		return Url::to('blog/post/'.$this->attributes['id']);
	}
}