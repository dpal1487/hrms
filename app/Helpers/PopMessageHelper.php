<?php

if (!function_exists('SuccessMessage')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function CreateMessage()
    {
        return "Successfully created.";
    }
    function UpdateMessage()
    {
        return "Successfully updated.";
    }
    function DeleteMessage()
    {
        return "Successfully deleted.";
    }

    function ErrorMessage()
    {
        return "Opps! something went wrong.";
    }
    function StatusMessage()
    {
        return "Status Update Successfully.";
    }
};
