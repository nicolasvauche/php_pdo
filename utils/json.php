<?php
/**
 * fileJsonToArray
 *
 * This function opens a json file and ouputs its content as an arrray
 *
 * @param string $jsonFile
 *
 * @return array
 *
 * @throws Exception If file is corrupted
 */
function fileJsonToArray(string $jsonFile = null): array
{
    // Output array initialisation
    $output = [];

    if (file_exists($jsonFile)) {
        try {
            // Get file content as string
            $json = file_get_contents($jsonFile);

            if (isJson($json)) {
                // Decode JSON ans create a temporary array to contain data
                $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(json_decode($json, true)),
                    RecursiveIteratorIterator::SELF_FIRST
                );

                // Save data into our output array
                foreach ($jsonIterator as $key => $val) {
                    if (is_array($val)) {
                        $output[] = $key;
                    } else {
                        $output[$key] = $val;
                    }
                }
            }
        } catch (Exception $e) {
            // L'exception levée par PDO est correctement captée ici
            echo "<p>Une Exception a été levée :(<br />" . $e->getMessage() . "</p>";
        }
    }

    // Return output array: can be empty
    return $output;
}

/**
 * isJson
 *
 * This function returns true if given string is json, false if not
 *
 * @param string $string
 *
 * @return bool
 */
function isJson(string $string): bool
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
