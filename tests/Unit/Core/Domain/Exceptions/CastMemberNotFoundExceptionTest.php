<?php

namespace Tests\Unit\Core\Domain\Exceptions;

use Core\Domain\Exceptions\CastMemberNotFoundException;
use Core\Domain\ValueObjects\CastMemberId;

$id = CastMemberId::generate();
$message = 'CastMember not found using ID: '.(string) $id;

test('Valida mensagem e tipo retornado', function () use ($id) {
    throw new CastMemberNotFoundException($id);
})->throws(CastMemberNotFoundException::class, $message);
