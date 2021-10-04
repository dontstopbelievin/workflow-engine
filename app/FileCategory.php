<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileCategory extends Model
{
    protected $table = "files_categories";
    const XML                               = 1; // XML
    const IMG                               = 2; // PNG/JPG/JPEG
    const DOC                               = 3; // DOC/DOCX
    const PDF                               = 4; // PDF
    const PPT                               = 5; // PPT
    const ARCHIVE                           = 6; // ZIP/RAR
}
