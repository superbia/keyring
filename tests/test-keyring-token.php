<?php
/**
 * Class TokenTest
 *
 * @package Keyring
 */

/**
 * Token test case.
 */
class TokenTest extends WP_UnitTestCase {

	public function test_token_is_expired_with_no_expires_is_false() {
		$token = new Keyring_Access_Token( 'OAuth2', 'token' );
		$this->assertFalse( $token->is_expired() );
	}

	public function test_token_is_expired_with_infinite_expires_is_false() {
		$token = new Keyring_Access_Token(
			'OAuth2',
			'token',
			[
				'expires' => '0000-00-00 00:00:00',
			]
		);

		$this->assertFalse( $token->is_expired() );
	}

	public function test_token_is_expired_with_future_expiry_is_false() {
		$token = new Keyring_Access_Token(
			'OAuth2',
			'token',
			[
				'expires' => time() + HOUR_IN_SECONDS,
			]
		);

		$this->assertFalse( $token->is_expired() );
	}

	public function test_token_is_expired_with_past_expiry_is_true() {
		$token = new Keyring_Access_Token(
			'OAuth2',
			'token',
			[
				'expires' => time() - HOUR_IN_SECONDS,
			]
		);

		$this->assertTrue( $token->is_expired() );
	}
}
