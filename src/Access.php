<?php

namespace Christianhanggra\Bizzy\Select\Permission;

use Illuminate\Http\Request;
use Christianhanggra\Bizzy\Select\Permission\Contracts\AccessInterface;
use Christianhanggra\Bizzy\Select\Permission\Repositories\UserRepository;

class Access implements AccessInterface
{
	protected $request;
	protected $userRepository;

	/*
	 * Intialize depedency injection
	 */
	function __construct(Request $request,
						 UserRepository $userRepository)
	{
		$this->request = $request;
		$this->userRepository = $userRepository;
	}

	/*
	 * Function id
	 *
	 * Get id user
	 *
	 * @return string
	 */
	public function id()
	{
		return $this->request->user()->id;
	}

	/*
	 * Function user
	 *
	 * Get user data
	 *
	 * @return array
	 */
	public function user()
	{
		return $this->userRepository->findByUserId($this->id());
	}

	/*
	 * Function roles
	 *
	 * A user may have multiple roles
	 *
	 * @return array
	 */
	public function roles()
	{
		$data = [];
		$user = $this->user();
	
		if($roles = $user->roles){
			foreach($roles as $row){
				$data[] = $row->role->name;
			}
		}

		return $data;
	}

	/*
	 * Function permissions
	 *
	 * A user may have multiple direct permissions
	 *
	 * @return array
	 */
	public function permissions()
	{
		$data = [];
		$user = $this->user();
		
		if($permissions = $user->permissions){
			foreach($permissions as $row){
				$data[] = $row->permission->name;
			}
		}

		return $data;
	}

	/*
	 * Function groups
	 *
	 * A user may have multiple direct groups
	 *
	 * @return array
	 */
	public function groups()
	{
		$data = [];
		$user = $this->user();

		if($roles = $user->roles){
			foreach($roles as $row){
				if($groups = $row->groups){
					foreach($groups as $res){
						$data[] = [
							'id' => $res->id,
							'name' => $res->group->name,
						];
					}
				}
			}
		}

		return $data;
	}

	/*
	 * Function products
	 *
	 * A user may have multiple direct products
	 *
	 * @return array
	 */
	public function products()
	{
		$data = [];
		$user = $this->user();
	
		if($roles = $user->roles){
			foreach($roles as $row){
				if($products = $row->products){
					foreach($products as $res){
						$data[] = [
							'id' => $res->id,
							'name' => $res->product->name,
						];
					}
				}
			}
		}

		return $data;
	}

	/*
	 * Function hasRole
	 *
	 * Determine if the user has (one of) the given role(s)
	 *
	 * @param string|array $name: one or array of roles
	 * @return array
	 */
	public function hasRole($name)
	{
		return in_array($name, $this->roles());
	}

	/*
	 * Function hasGroup
	 *
	 * Determine if the user has (one of) the given group(s)
	 *
	 * @param string|array $name: one or array of groups
	 * @return array
	 */
	public function hasGroup($id)
	{
		if($groups = $this->groups()){
			foreach($groups as $row){
				if($row['id'] == $id) return true;
			}
		}

		return false;
	}

	/*
	 * Function hasProduct
	 *
	 * Determine if the user has (one of) the given product(s)
	 *
	 * @param string|array $name: one or array of products
	 * @return array
	 */
	public function hasProduct($id)
	{
		if($products = $this->products()){
			foreach($products as $row){
				if($row['id'] == $id) return true;
			}
		}

		return false;
	}

	/*
	 * Function can
	 *
	 * Determine if the entity has a given ability
	 *
	 * @param string: one of permissions
	 * @return bool
	 */
	public function can($name)
	{
		return in_array($name, $this->permissions());
	}

	/*
	 * Function cant
	 *
	 * Determine if the entity does not have a given ability
	 *
	 * @param string: one of permissions
	 * @return bool
	 */
	public function cant($name)
	{
		if(! $permissions = $this->permissions()){
			return true;
		}
		
		return (! in_array($name, $permissions));
	}

	/*
	 * Function cannot
	 *
	 * Determine if the entity does not have a given ability
	 *
	 * @param string: one of permissions
	 * @return bool
	 */
	public function cannot($name)
	{
		return $this->cant($name);
	}
}