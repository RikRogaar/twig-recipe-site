<?php

function showTemplate($template, $data = [])
{
    $loader = new \Twig\Loader\FilesystemLoader('../views');
    $twig = new \Twig\Environment($loader);
    $template = $twig->load($template);
    $template->display($data);
}

function error($errorNumber, $errorMessage)
{
    showTemplate('error.twig', [
        'errorNumber' => $errorNumber,
        'errorMessage' => $errorMessage,
    ]);
    die;
}

function getPath(): array
{
    $path = strtok($_GET['params'], '?');

    while (str_contains($path, '//')) {
        $path = str_replace('//', '/', $path);
    }

    if ($path === '/') {
        return [];
    }

    return explode('/', trim($path, '/'));
}