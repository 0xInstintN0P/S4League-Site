<?php

    function pbkdf2($password, $salt) {
        if(!in_array('sha1', hash_algos(), true))
        {
            die('Couldn\'t initialise PBKDF2');
        }

        $hash_length = strlen(hash('sha1', '', true));
        $block_count = ceil(24 / $hash_length);

        $output = '';
        for($i = 1; $i <= $block_count; $i++)
        {
            $last = $salt.pack('N', $i);
            $last = $xorsum = hash_hmac('sha1', $last, $password, true);
            for($j = 1; $j < 24000; $j++)
            {
                $xorsum ^= ($last = hash_hmac('sha1', $last, $password, true));
            }

            $output .= $xorsum;
        }

        return substr($output, 0, 24);
    }

    function hash_equal($a, $b) {
        $ret = strlen($a) ^ strlen($b);
        $ret |= array_sum(unpack("C*", $a^$b));
        return !$ret;
    }

    function check_password($password, $hash, $salt) {
        $salt = base64_decode($salt);
        $password_guess = pbkdf2($password, $salt);
        $actual_password = base64_decode($hash);

        return hash_equal($actual_password, $password_guess);
    }

    function create_password($password) {
        $result = new stdClass;

        $salt = \random_bytes(24);
        $hash = pbkdf2($password, $salt);

        $result->salt = base64_encode($salt);
        $result->hash = base64_encode($hash);

        return $result;
    }
    