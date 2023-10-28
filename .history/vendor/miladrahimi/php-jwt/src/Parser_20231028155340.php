<?php

namespace Esmaeeli\Jwt;

use Esmaeeli\Jwt\Base64\SafeBase64Parser;
use Esmaeeli\Jwt\Base64\Base64Parser;
use Esmaeeli\Jwt\Cryptography\Verifier;
use Esmaeeli\Jwt\Exceptions\JsonDecodingException;
use Esmaeeli\Jwt\Exceptions\InvalidSignatureException;
use Esmaeeli\Jwt\Exceptions\InvalidTokenException;
use Esmaeeli\Jwt\Exceptions\ValidationException;
use Esmaeeli\Jwt\Json\StrictJsonParser;
use Esmaeeli\Jwt\Json\JsonParser;
use Esmaeeli\Jwt\Validator\DefaultValidator;
use Esmaeeli\Jwt\Validator\Validator;

/**
 * Class Parser
 *
 * @package Esmaeeli\Jwt
 */
class Parser
{
    /**
     * @var Verifier
     */
    private $verifier;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var JsonParser
     */
    private $jsonParser;

    /**
     * @var Base64Parser
     */
    private $base64Parser;

    /**
     * Parser constructor.
     *
     * @param Verifier $verifier
     * @param Validator|null $validator
     * @param JsonParser|null $jsonParser
     * @param Base64Parser|null $base64Parser
     */
    public function __construct(
        Verifier $verifier,
        Validator $validator = null,
        JsonParser $jsonParser = null,
        Base64Parser $base64Parser = null
    )
    {
        $this->setVerifier($verifier);
        $this->setValidator($validator ?: new DefaultValidator());
        $this->setJsonParser($jsonParser ?: new StrictJsonParser());
        $this->setBase64Parser($base64Parser ?: new SafeBase64Parser());
    }

    /**
     * Parse (and also verify and validate) the JWT, then retrieve claims
     *
     * @param string $jwt
     * @return array|array[string]mixed
     * @throws Exceptions\SigningException
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws ValidationException
     */
    public function parse(string $jwt): array
    {
        list($header, $payload, $signature) = $this->explodeJwt($jwt);

        $this->verifySignature($header, $payload, $signature);

        $claims = $this->extractClaims($payload);

        $this->validator->validate($claims);

        return $claims;
    }

    /**
     * Explode jwt to its sections
     *
     * @param string $jwt
     * @return string[] [header, payload, signature]
     * @throws InvalidTokenException
     */
    private function explodeJwt(string $jwt): array
    {
        $sections = explode('.', $jwt);

        if (count($sections) != 3) {
            throw new InvalidTokenException('Token format is not valid');
        }

        return $sections;
    }

    /**
     * Verify the JWT
     *
     * @param string $jwt
     * @throws Exceptions\SigningException
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     */
    public function verify(string $jwt)
    {
        list($header, $payload, $signature) = $this->explodeJwt($jwt);

        $this->verifySignature($header, $payload, $signature);
    }

    /**
     * Verify the JWT signature
     *
     * @param string $header
     * @param string $payload
     * @param string $signature
     * @throws Exceptions\SigningException
     * @throws InvalidSignatureException
     */
    private function verifySignature(string $header, string $payload, string $signature)
    {
        $signature = $this->base64Parser->decode($signature);

        $this->verifier->verify("$header.$payload", $signature);
    }

    /**
     * Extract claims from JWT
     *
     * @param string $payload
     * @return array
     * @throws JsonDecodingException
     */
    private function extractClaims(string $payload): array
    {
        return $this->jsonParser->decode($this->base64Parser->decode($payload));
    }

    /**
     * Validate JWT (verify signature and validate claims)
     *
     * @param string $jwt
     * @throws Exceptions\SigningException
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws ValidationException
     */
    public function validate(string $jwt)
    {
        list($header, $payload, $signature) = $this->explodeJwt($jwt);

        $this->verifySignature($header, $payload, $signature);

        $claims = $this->extractClaims($payload);

        $this->validator->validate($claims);
    }

    /**
     * @return JsonParser
     */
    public function getJsonParser(): JsonParser
    {
        return $this->jsonParser;
    }

    /**
     * @param JsonParser $jsonParser
     */
    public function setJsonParser(JsonParser $jsonParser)
    {
        $this->jsonParser = $jsonParser;
    }

    /**
     * @return Base64Parser
     */
    public function getBase64Parser(): Base64Parser
    {
        return $this->base64Parser;
    }

    /**
     * @param Base64Parser $base64Parser
     */
    public function setBase64Parser(Base64Parser $base64Parser)
    {
        $this->base64Parser = $base64Parser;
    }

    /**
     * @return Verifier
     */
    public function getVerifier(): Verifier
    {
        return $this->verifier;
    }

    /**
     * @param Verifier $verifier
     */
    public function setVerifier(Verifier $verifier)
    {
        $this->verifier = $verifier;
    }

    /**
     * @return Validator
     */
    public function getValidator(): Validator
    {
        return $this->validator;
    }

    /**
     * @param Validator $validator
     */
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }
}
