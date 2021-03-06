<?php

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
final class MarketPlaceOpenStackPoweredExpireServicesDigestTask extends CronTask
{

    /**
     * @var int
     */
    private $day_about_to_expire_on;

    /**
     * @var IPoweredOpenStackImplementationManager
     */
    private $manager;

    /**
     * @var IMessageSenderService
     */
    private $message_sender_service;

    /**
     * MarketPlaceOpenStackPoweredExpireServicesDigestTask constructor.
     * @param IMessageSenderService $message_sender_service
     * @param IPoweredOpenStackImplementationManager $manager
     * @param int $day_about_to_expire_on
     */
    public function __construct
    (
        IMessageSenderService $message_sender_service,
        IPoweredOpenStackImplementationManager $manager,
        $day_about_to_expire_on
    )
    {
        parent::__construct();
        $this->message_sender_service = $message_sender_service;
        $this->manager                = $manager;
        $this->day_about_to_expire_on = $day_about_to_expire_on;
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->manager->sendExpiredPoweredProgramDigest
        (
            $this->message_sender_service,
            $this->day_about_to_expire_on
        );
    }
}