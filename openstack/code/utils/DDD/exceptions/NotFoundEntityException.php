<?php
/**
 * Copyright 2014 Openstack Foundation
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 **/
/**
 * Class NotFoundEntityException
 */
class NotFoundEntityException extends Exception {

	/**
	 * NotFoundEntityException constructor.
	 * @param string $class_name
	 * @param string $criteria
	 */
	public function __construct($class_name , $criteria = ''){
		$message = sprintf('Entity %s by %s not found!.',$class_name,$criteria);
		parent::__construct($message);
	}
}