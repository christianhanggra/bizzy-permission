<?php

namespace Christianhanggra\Bizzy\Permission;

use Illuminate\Http\Request;
use Christianhanggra\Bizzy\Permission\Contracts\AccessInterface;
use Christianhanggra\Bizzy\Permission\Repositories\UserRepository;
use Christianhanggra\Bizzy\Permission\Repositories\PortalRepository;

class Access implements AccessInterface
{
	protected $request;
	protected $userRepository;
	protected $portalRepository;

	/*
	 * Intialize depedency injection
	 */
	function __construct(Request $request,
						 UserRepository $userRepository,
						 PortalRepository $portalRepository)
	{
		$this->request = $request;
		$this->userRepository = $userRepository;
		$this->portalRepository = $portalRepository;
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
	 * Function portal
	 *
	 * A user may have one of portal
	 *
	 * @param string $id: primary key portal data
	 * @return array
	 */
	public function portal($id)
	{
		return $this->portalRepository->find($id);
	}

	/*
	 * Function userportal
	 *
	 * Mixed user data with related portal data
	 *
	 * @return array
	 */
	public function userportal()
	{
        if(! $user = $this->user()) 
        	return false;

        if(! $portal = $this->portal($user->portal_id)) 
        	return false;

        return [
            'user_id' => $user->user_id,
            'portal_id' => $portal->id,
            'portal' => [
	            'magento' => [
	            	'customer_id' => $portal->magento['customer_id'],
	            	'company_id' => $portal->magento['company_id'],
	            ],
	            'netsuite' => [
	            	'customer_id' => $portal->netsuite['customer_id'],
	            	'contact_id' => $portal->netsuite['contact_id'],
	            ],
            	'domain' => $portal->domain,
            ],
            'status' => $user->status,
        ];
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

		if($roles = $user->roles){
			foreach($roles as $row){
				if($permissions = $row->role->permissions){
					foreach($permissions as $row){
						$data[] = $row->permission->name;
					}
				}
			}
		}

		if($permissions = $user->permissions){
			foreach($permissions as $row){
				$data[] = $row->permission->name;
			}
		}

		$data = array_keys(array_flip($data));

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
	 * Function contains
	 *
	 * Get comparison search array value in of array
	 *
	 * @param array $needle: the searched value
	 * @param array $haystack: the array
	 * @return bool
	 */
	public function contains($needle, $haystack)
	{
		$find = 0;
		$count = count($needle);

		if(! $count) return false;

		if($haystack){
			foreach($needle as $search){
				if(in_array($search, $haystack)){
					$find++;
				}
			}
		}

		return ($count === $find);
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
		if(is_array($name)){
			return $this->contains($name, $this->roles());
		}else{
			return in_array($name, $this->roles());
		}
	}

	/*
	 * Function hasProduct
	 *
	 * Determine if the user has (one of) the given product(s)
	 *
	 * @param string $id: one or array of products
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
	 * Function hasGroup
	 *
	 * Determine if the user has (one of) the given group(s)
	 *
	 * @param string $id: one or array of groups
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
	 * Function can
	 *
	 * Determine if the entity has a given ability
	 *
	 * @param string $name: one of permissions
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
	 * @param string $name: one of permissions
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
	 * @param string $name: one of permissions
	 * @return bool
	 */
	public function cannot($name)
	{
		return $this->cant($name);
	}
}