<?php
    namespace PSDO\Enums\Session;

    use PSDO\Enums\Enum;

    class SessionState extends Enum {
        const NotInit = 0;
        const Guest = 1;
        const TryAuth = 2;
        const Auth = 3;
    }