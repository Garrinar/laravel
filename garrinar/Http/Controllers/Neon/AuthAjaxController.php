<?php

namespace Garrinar\Http\Controllers\Neon {

    use Garrinar\Http\Controllers\AjaxController;
    use Garrinar\Http\Response\Neon\LoginAjaxResponse;

    class AuthAjaxController extends AjaxController
    {
        public function authenticated()
        {
            return new LoginAjaxResponse(['login_status' => 'success', 'redirect_url' => url('home')]);
        }
    }
}
