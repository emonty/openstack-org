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
 * Class SapphireConsultantRepository
 */
final class SapphireConsultantRepository
	extends SapphireRegionalSupportedCompanyServiceRepository {

    public function __construct($draft_entity=false){
        $entity = ($draft_entity) ? new ConsultantDraft() : new Consultant();
        parent::__construct($entity);
    }

	public function delete($entity){
		$entity->clearClients();
		$entity->clearOffices();
		$entity->clearSpokenLanguages();
		$entity->clearExpertiseAreas();
		$entity->clearServicesOffered();
		parent::delete($entity);
	}

	/**
	 * @return string
	 */
	protected function getMarketPlaceTypeGroup()
	{
		return IConsultant::MarketPlaceGroupSlug;
	}
}