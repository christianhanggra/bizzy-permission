<?php

namespace Christianhanggra\Bizzy\Permission\Contracts;

Interface AccessInterface
{
	/*
	 * Function id
	 *
	 * Get id user
	 *
	 * @return string
	 */
	public function id();

	/*
	 * Function user
	 *
	 * Get user data
	 *
	 * @return array
	 */
	public function user();
	
	/*
	 * Function portal
	 *
	 * A user may have one of portal
	 *
	 * @param string $id: primary key portal data
	 * @return array
	 */
	public function portal($id);

	/*
	 * Function userportal
	 *
	 * Mixed user data with related portal data
	 *
	 * @return array
	 */
	public function userportal();

	/*
	 * Function roles
	 *
	 * A user may have multiple roles
	 *
	 * @return array
	 */
	public function roles();

	/*
	 * Function permissions
	 *
	 * A user may have multiple direct permissions
	 *
	 * @return array
	 */
	public function permissions();

	/*
	 * Function groups
	 *
	 * A user may have multiple direct groups
	 *
	 * @return array
	 */
	public function groups();
	
	/*
	 * Function products
	 *
	 * A user may have multiple direct products
	 *
	 * @return array
	 */
	public function products();

	/*
	 * Function contains
	 *
	 * Get comparison search array value in of array
	 *
	 * @param array $needle: the searched value
	 * @param array $haystack: the array
	 * @return bool
	 */
	public function contains($needle, $haystack);

	/*
	 * Function hasRole
	 *
	 * Determine if the user has (one of) the given role(s)
	 *
	 * @param string|array $name: one or array of roles
	 * @return array
	 */
	public function hasRole($name);

	/*
	 * Function hasProduct
	 *
	 * Determine if the user has (one of) the given product(s)
	 *
	 * @param string $id: one or array of products
	 * @return array
	 */
	public function hasProduct($id);

	/*
	 * Function hasGroup
	 *
	 * Determine if the user has (one of) the given group(s)
	 *
	 * @param string $id: one or array of groups
	 * @return array
	 */
	public function hasGroup($id);
	
	/*
	 * Function can
	 *
	 * Determine if the entity has a given ability
	 *
	 * @param string $name: one of permissions
	 * @return bool
	 */

	public function can($name);

	/*
	 * Function cant
	 *
	 * Determine if the entity does not have a given ability
	 *
	 * @param string $name: one of permissions
	 * @return bool
	 */
	public function cant($name);

	/*
	 * Function cannot
	 *
	 * Determine if the entity does not have a given ability
	 *
	 * @param string $name: one of permissions
	 * @return bool
	 */
	public function cannot($name);
}