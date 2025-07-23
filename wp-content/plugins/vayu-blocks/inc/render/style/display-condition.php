<?php
$options = (new VAYU_BLOCKS_OPTION_PANEL())->get_option();

class VAYUBLOCKS_DISPLAY_CONDITION {

    public static $attribute = array();

    public function __construct($attr) {
        self::$attribute = $attr;
    }

    public function display() {
        if (!isset(self::$attribute['advDisplayCond']) || !is_array(self::$attribute['advDisplayCond'])) {
            return '';
        }

        $conditions = self::$attribute['advDisplayCond'];

        

        foreach ($conditions as $key => $value) {
            if ($key === 'cond') {
                if ($value === 'none') {
                    return '';
                }
                continue;
            }

            switch ($key) {
                case 'user_state':
                    if ($this->checkUserState($value)) return true;
                    break;

                case 'user_role':
                    if ($this->checkUserRole($value)) return true;
                    break;

                case 'browser':
                    if ($this->checkBrowser($value)) return true;
                    break;

                case 'os':
                    if ($this->checkOS($value)) return true;
                    break;

                case 'day':
                    if ($this->checkDay($value)) return true;
                    break;

                case 'date':
                    if ($this->checkDate($value)) return true;
                    break;
                case 'time':
                    if ($this->checkTime($value)) return true;
                    break;
            }
        }
    }

    private function checkUserState($value) {
        if (isset($value['loggedIn']) && $value['loggedIn']) {
            if(is_user_logged_in()){
                return true;
            }
        }
        if (isset($value['loggedOut']) && $value['loggedOut']) {
            if(!is_user_logged_in()){
                return true;
            }
        }
    }

    private function checkUserRole($value) {
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $user_roles = (array) $user->roles;
            $required_roles = (array) $value;

            foreach ($required_roles as $required_role) {
                if (in_array(strtolower($required_role), array_map('strtolower', $user_roles), true)) {
                    return true;
                }
            }
        }
    }

    private function checkBrowser($value) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser_name = 'Unknown';

        if (strpos($user_agent, 'Chrome') !== false && strpos($user_agent, 'Edg') === false) {
            $browser_name = 'Google Chrome';
        } elseif (strpos($user_agent, 'Safari') !== false && strpos($user_agent, 'Chrome') === false) {
            $browser_name = 'Safari';
        } elseif (strpos($user_agent, 'Firefox') !== false) {
            $browser_name = 'Mozilla Firefox';
        } elseif (strpos($user_agent, 'Edg') !== false) {
            $browser_name = 'Microsoft Edge';
        } elseif (strpos($user_agent, 'Opera') !== false || strpos($user_agent, 'OPR') !== false) {
            $browser_name = 'Opera';
        }

        if (in_array(strtolower($browser_name), array_map('strtolower', $value), true)) {
            return true;
        }
    }

    private function checkOS($value) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_name = 'Unknown';

        if (stripos($user_agent, 'Windows') !== false) {
            $os_name = 'Windows';
        } elseif (stripos($user_agent, 'Linux') !== false && stripos($user_agent, 'Android') === false) {
            $os_name = 'Linux';
        } elseif (stripos($user_agent, 'Android') !== false) {
            $os_name = 'Android';
        } elseif (stripos($user_agent, 'iPhone') !== false || stripos($user_agent, 'iPad') !== false || stripos($user_agent, 'iOS') !== false) {
            $os_name = 'IOS';
        } elseif (stripos($user_agent, 'Macintosh') !== false || stripos($user_agent, 'Mac OS') !== false) {
            $os_name = 'Mac OS';
        } elseif (stripos($user_agent, 'SunOS') !== false) {
            $os_name = 'SunOS';
        } elseif (stripos($user_agent, 'OpenBSD') !== false) {
            $os_name = 'Open BSD';
        }

        if (in_array($os_name, $value, true)) {
            return true;
        }
    }

    private function checkDay($value) {
        $current_day = strtolower(date('l'));
        if (isset($value[$current_day]) && $value[$current_day]) {
            return true;
        }
    }

    private function checkDate($value) {
        $start = $value['start'] ?? null;
        $end = $value['end'] ?? null;

        if ($start && $end) {
            $today = date('Y-m-d');
            if ($today >= $start && $today <= $end) {
                return true;
            }
        }
    }

    private function checkTime($value) {
        $start = $value['start'] ?? null;
        $end = $value['end'] ?? null;

        if (!$start || !$end) {
            return ;
        }

        $currentTime = current_time('H:i'); 

        // Normalize for comparison
        $startTime = date('H:i', strtotime($start));
        $endTime = date('H:i', strtotime($end));

        if ($startTime <= $currentTime && $currentTime <= $endTime) {
            return true;
        }
    }

}
  
/**
    * Apply display condition check before rendering output.
    * If the condition evaluates to true, return an empty string to prevent rendering.
    
    * if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
    *    return '';
    * }
*/
