<?php
if (!function_exists('array_rename_keys')) {
    function array_rename_keys(array $data, array $oldKeys, array $newKeys): array
    {
        $keys = array_keys($data);
        foreach ($oldKeys as $oldKeyIndex => $oldKeyName)
        {
            $index = array_search($oldKeyName, $keys);
            if ($index === false)
            {
                continue;
            }

            $keys[$index] = $newKeys[$oldKeyIndex];
        }

        return array_combine($keys, array_values($data));
    }
}
