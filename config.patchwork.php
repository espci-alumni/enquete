<?php

#patchwork __patchwork__/pieces/pMail
#patchwork __patchwork__/pieces/doctrine
#patchwork __patchwork__/pieces/pForm/pieces/*
#patchwork __patchwork__/pieces/agent-controller

$CONFIG += array('clientside' => false);
$CONFIG += PCORG::DSN('enquete', 'doctrine.');
