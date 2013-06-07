; <?php exit(1); __halt_compiler();
; Quick hack to stop configuration file being exposed: all you see using a
; browser now is a semi-colon.



[DEBUG]
DEBUG_MODE = ON

[SERVER]
SERVER = localhost
PORT = 11211

[AUTH]
PASSWORD = ccd74845b72a1838a8be82d2a168d8151f773f72c5467a151bcc0bae23960cf6

[MISC]
PHP_TIMEZONE = UTC



; ?>
; end the fake PHP (see hack above)
