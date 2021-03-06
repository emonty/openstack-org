<?php
use \Openstack\DDD\Model\Entity;
/**
 * Copyright 2017 OpenStack Foundation
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
class CalendarSyncInfo extends DataObject implements ICalendarSyncInfo
{
    use Entity;

    private static $db = [
        'Provider'           => "Enum('Google, Outlook, iCloud','Google')",
        'CalendarExternalId' => 'Varchar(512)',
        'ETag'               => 'Varchar(512)',
        'Revoked'            => 'Boolean'
    ];

    private static $has_one = [
        'Summit' => 'Summit',
        'Owner'  => 'Member',
    ];

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->getField('Provider');
    }
}