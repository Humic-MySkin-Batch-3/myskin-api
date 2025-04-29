<?php
return [
    'predict_url'   => env('AI_PREDICT_URL'),
    'threshold'     => env('AI_MELANOMA_THRESHOLD', 50.0),
    'label_positive'=> env('AI_MELANOMA_LABEL', 'Melanoma'),
    'label_negative'=> env('AI_NEGATIVE_LABEL', 'Negative'),
];
