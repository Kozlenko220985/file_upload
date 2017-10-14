<?php

/**
 * @param  string $string
 * @param  array  $rules
 * @return bool
 */
function censor ($string, $rules) {
    foreach ($rules as $rule) {
        if (is_int(strpos(strtolower($string), $rule))) {
            return false;
        }
    }

    return true;
}

/**
 * @param  array             $data
 * @param  array             $stop_words
 * @return array|null|string
 */
function sanitize($data, $stop_words)
{
    $response = null;

//    if (!is_array($data) && !is_string($data)) {
//        throw new InvalidArgumentException(sprintf('First argument must be an array or string, %s given', gettype($data)));
//    }

    if (is_array($data)) {
        foreach ($data as $key => $item) {
            if(!censor($item, $stop_words)){
                return null;
            }
            $data[$key] = htmlspecialchars(strip_tags(trim($item)));
        }
        $response = $data;
    } else {
        $response = htmlspecialchars(strip_tags(trim($data)));
    }

    return $response;
}

/**
 * @param  string $username
 * @param  string $message
 * @return int
 */
function save($username, $message)
{
    $to_save = json_encode(['username' => $username, 'message' => $message]) . PHP_EOL;
    return file_put_contents('messages.txt', $to_save, FILE_APPEND);
}

/**
 * @return array
 */
function read()
{
    $content = [];
    $handle = fopen("messages.txt", "r");

    if($handle) {
        while (($line = fgets($handle)) !== false) {
            $content[] = json_decode($line, true);
        }
    }

    return $content;
}

if (isset($_POST['contact_form'])) {// проверяем существование инпута

    $stop_words = ['stop','fuck']; // массив с цензурой

    if ($data = sanitize($_POST['contact_form'], $stop_words)) {//функ возвращает если ок массив нет null переходит на
        // else и присваевает в data
        save(...array_values($data)); // переиндексация с помощью 3 точек передаем 2 парам как один из массива
        // в функцию передаем масив если все ок и сохраняем запись

        if (isset($comments)) {//если массив существ то ьерджим его с функц которая возвр массив
            $comments = array_merge($comments, read());
        } else {//нет то просто читаем
            read();
        }

    } else {
        $error = 'The comment is invalid';
    }

}

$comments = read();

?>