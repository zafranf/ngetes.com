<?php
if (checkFlashMessages()) {
    debug(getFlashMessages());
}
return view($controller);
