<?php

namespace views;
/**
 * @author Maurits Seelen (25/05/2017)
 * Class JsonView
 */
class JsonView implements View
{
    public function show(array $data)
    {
        header('Content-Type: application/json');

        if (isset($data['toShow']))
        {
            $event = $data['toShow'];
            echo json_encode($event);
        } else {
            echo '{No Data Found.}';
        }
    }
}