<?php

/**
 * Copyright 2015 OpenStack Foundation
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
class SummitEventType extends DataObject implements ISummitEventType
{

    use Colorable;

    private static $db = array
    (
        'Type'                 => 'Text',
        'Color'                => 'Text',
        'BlackoutTimes'        => 'Boolean',
        'UseSponsors'          => 'Boolean',
        'AreSponsorsMandatory' => 'Boolean',
        'AllowsAttachment'     => 'Boolean',
        'IsDefault'            => 'Boolean',
        'IsPrivate'            => 'Boolean',
    );

    private static $has_many = [];

    private static $defaults = [
        'UseSponsors'          => 0,
        'AreSponsorsMandatory' => 0,
        'AllowsAttachment'     => 0,
        'BlackoutTimes'        => 0,
        'IsPrivate'            => 0,
        'Color'                => 'f0f0ee',
    ];

    private static $has_one = [
        'Summit' => 'Summit'
    ];

    private static $summary_fields = [
        'Type'
    ];

    private static $searchable_fields = [
        'Type'
    ];
    /**
     * @return int
     */
    public function getIdentifier()
    {
        return (int)$this->getField('ID');
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getField('Type');
    }

    /**
     * @return integer
     */
    public function getBlackoutTimes()
    {
        return $this->getField('BlackoutTimes');
    }

    public function canDelete($member=null) {
        if ($this->IsDefault)
        {
            return false;
        }
        return parent::canDelete($member);
    }

    public function getCMSFields() {
        $fields = new FieldList();
        $fields->add($type_txt = new TextField('Type','Type'));
        if($this->ID > 0  && $this->IsDefault)
        {
            $type_txt->setReadonly(true);
        }
        $fields->add(new ColorField("Color","Color"));
        $fields->add(new CheckboxField("BlackoutTimes","Blackout Times"));
        $fields->add(new CheckboxField("UseSponsors","Should use Sponsors?"));
        $fields->add(new CheckboxField("AreSponsorsMandatory","Are Sponsors Mandatory?"));
        $fields->add(new CheckboxField("AllowsAttachment","Allows Attachment?"));
        $fields->add(new HiddenField('SummitID','SummitID'));
        return $fields;
    }

    protected function onAfterWrite() {
        parent::onAfterWrite();
    }

    protected function validate()
    {
        $valid = parent::validate();
        if(!$valid->valid()) return $valid;

        $summit_id = isset($_REQUEST['SummitID']) &&  intval($_REQUEST['SummitID']) > 0 ?  $_REQUEST['SummitID'] : $this->SummitID;

        $summit   = Summit::get()->byID($summit_id);

        if(!$summit)
        {
            return $valid->error('Invalid Summit!');
        }

        $count = intval(SummitEventType::get()->filter(array('SummitID' => $summit->ID, 'Type' => trim($this->Type), 'ID:ExactMatch:not' => $this->ID))->count());

        if($count > 0)
            return $valid->error(sprintf('Summit Event Type %s already exists!. please set another one', $this->Type));

        return $valid;
    }

    /**
     * @param Member $member
     * @return boolean
     */
    public function canView($member = null) {
        return Permission::check("ADMIN") || Permission::check("ADMIN_SUMMIT_APP") || Permission::check("ADMIN_SUMMIT_APP_SCHEDULE");
    }

    /**
     * @param Member $member
     * @return boolean
     */
    public function canEdit($member = null) {
        return Permission::check("ADMIN") || Permission::check("ADMIN_SUMMIT_APP") || Permission::check("ADMIN_SUMMIT_APP_SCHEDULE");
    }

    /**
     * @param string $type
     * @return bool
     */
    static public function IsSummitEventType($type){
        return !PresentationType::IsPresentationEventType($type);
    }

    /**
     * @param string $type
     * @return bool
     */
    static public function isPrivate($type){
       $event_type = SummitEventType::get()->filter(['Type' => $type])->first();
       return is_null($event_type) ? false : boolval($event_type->IsPrivate);
    }

}