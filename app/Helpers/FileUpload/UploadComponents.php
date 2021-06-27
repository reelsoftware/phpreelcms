<?php
namespace App\Helpers\FileUpload; 

class UploadComponents
{
    /**
     * Return the env fields
     *
     * @return array
     */
    public static function getUploadForm()
    {
        return ('
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <div class=\"custom-file\">
                                <input type=\"file\" class=\"custom-file-input\" id=\"resourceFile\" onchange=\"updateFileLabel(\"resourceFile\")\">
                                <label class=\"custom-file-label\" for=\"resourceFile\">Upload files</label>
                            </div>
                        </div>
                            
                        <div class=\"progress\">
                            <div id=\"progressBar\" class=\"progress-bar\" role=\"progressbar\"></div>
                        </div>   

                        <div class=\"card-body\">
                            <h5 class=\"card-title\">Uploaded files</h5>

                            <div id=\"uploadedFiles\">
                                <p class=\"card-text\"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ');
    }
}