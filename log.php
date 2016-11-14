class Log {

    const LEVEL_OFF = 0; // The highest possible rank and is intended to turn off logging.
    const LEVEL_FATAL = 1; // Designates very severe error events that will presumably lead the application to abort.
    const LEVEL_ERROR = (1 | 2); // Designates error events that might still allow the application to continue running.
    const LEVEL_WARN = (1 | 2 | 4); // Designates potentially harmful situations.
    const LEVEL_INFO = (1 | 2 | 4 | 8); // Designates informational messages that highlight the progress of the application at coarse-grained level.
    const LEVEL_DEBUG = (1 | 2 | 4 | 8 | 16); // Designates fine-grained informational events that are most useful to debug an application.
    const LEVEL_TRACE = (1 | 2 | 4 | 8 | 16); // Designates finer-grained informational events than the DEBUG.
    const LEVEL_ALL = (1 | 2 | 4 | 8 | 16 ); // All levels including custom levels.
    const LOG_DATA_DIR = '/var/www/manager/storage/logs/';
    const LOG_Mode = 3; // http://php.net/manual/pt_BR/function.error-log.php

    private $level;
    private $logFileName;

    /*
     * Instância da Classe
     * @var  Application
     */
    protected static $instance = NULL;

    protected function __construct($level, $file) {
        $this->level = $level;
        $this->logFileName = static::LOG_DATA_DIR . "/" . ((empty($file)) ? 'custom_pbx_ami.log' : $file);
    }

    public static function getInstance($level = 31, $file = 'custom_pbx_ami.log') {
        if (is_null(self::$instance)) {
            self::$instance = new static($level, $file);
        }
        return self::$instance;
    }

    public function __destruct() {
        
    }

    public function fileRotation() {
        if (file_exists($this->logFileName) && is_writable($this->logFileName)) {
            
        }
    }

    private function writeLog($levelId, $levelText, ...$messages) {
        var_dump($levelId, $levelText, $messages);
        if (($this->level & $levelId) == $levelId) {
            foreach ($messages as $message) {
                error_log(sprintf("%s [%s] %s\r\n", date('Y-m-d H:i:s'), $levelText, $message), static::LOG_Mode, $this->logFileName);
            }
        }
    }

   

    public function log(...$messages) {        
        $this->writeLog(self::LEVEL_ALL, 'LOG', ...$messages);
    }

    public function trace(...$messages) {        
        $this->writeLog(self::LEVEL_TRACE, 'TRACE', ...$messages);
    }

    public function debug(...$messages) {        
        $this->writeLog(self::LEVEL_DEBUG, 'DEBUG', ...$messages);
    }

    public function info(...$messages) {
        $this->writeLog(self::LEVEL_INFO, 'INFO', ...$messages);
    }

    public function warn(...$messages) {
       $this->writeLog(self::LEVEL_WARN, 'WARNING', ...$messages);
    }

    public function error(...$messages) {
        $this->writeLog(self::LEVEL_ERROR, 'ERROR', ...$messages);       
    }

    public function fatal(...$messages) {
         $this->writeLog(self::LEVEL_FATAL, 'FATAL', ...$messages);
    }

}
