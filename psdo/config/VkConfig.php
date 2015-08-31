<?php
    namespace PSDO\Config;

    class VkConfig extends BaseConfig {
        const configStoreName = 'VKAPI';

        protected function load() {
            // api version
            $this->data['ver']                  = '5.37';

            // !!!
            $this->data['client_id']            = '3770573';
            $this->data['client_secret']        = 'UenkNLZ32JKGYtTukHTn';

            $this->data['callback_uri']         = 'http://localhost/auth/vkCallback';
        }
    }