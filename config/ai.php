<?php
return [
    'predict_url'   => env('AI_PREDICT_URL'),
    'threshold'     => env('AI_MELANOMA_THRESHOLD', 0.5),
    'label_positive'=> env('AI_MELANOMA_LABEL', 'Melanoma'),
    'label_negative'=> env('AI_NEGATIVE_LABEL', 'Non-Melanoma'),
];
