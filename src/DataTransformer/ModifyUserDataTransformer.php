<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ModifyUserDataTransformer implements DataTransformerInterface
{
    private $securityEncoder;

    public function __construct(UserPasswordEncoderInterface $securityEncoder)
    {
        $this->securityEncoder = $securityEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $user = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        $user->setEmail($data->email);
        $user->setPassword($this->securityEncoder->encodePassword($user, $data->password));

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof User) {
            return false;
        }

        return User::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
