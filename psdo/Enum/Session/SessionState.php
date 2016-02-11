<?php
    namespace PSDO\Enum\Session;

    use PSDO\Enum\Enum;

    class SessionState extends Enum {
        const NotInit = 0;
        const Guest = 1;
        const TryAuth = 2;
        const Auth = 3;
    }