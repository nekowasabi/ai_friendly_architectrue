<?php

use PHPUnit\Framework\TestCase;

class SearchBarTest extends TestCase
{
    public function testDisplaySearchBar()
    {
        ob_start();
        displaySearchBar();
        $output = ob_get_clean();
        $this->assertStringContainsString('<input', $output, '検索バーのinput要素が存在すること');
        $this->assertStringContainsString('<button', $output, '検索ボタンが存在すること');
    }

    public function testGetUserInfo()
    {
        // テスト用のユーザーデータ (実際のデータ構造に合わせてください)
        $users = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
        ];

        // 名前で検索
        $result = getUserInfo('John Doe', '', 0);
        $this->assertCount(1, $result, '名前で検索した場合、1件の結果が返されること');
        $this->assertEquals('john.doe@example.com', $result[0]['email'], '検索されたユーザーのメールアドレスが正しいこと');

        // メールアドレスで検索
        $result = getUserInfo('', 'jane.smith@example.com', 0);
        $this->assertCount(1, $result, 'メールアドレスで検索した場合、1件の結果が返されること');
        $this->assertEquals('Jane Smith', $result[0]['name'], '検索されたユーザーの名前が正しいこと');

        // ユーザーIDで検索
        $result = getUserInfo('', '', 1);
        $this->assertCount(1, $result, 'ユーザーIDで検索した場合、1件の結果が返されること');
        $this->assertEquals('john.doe@example.com', $result[0]['email'], '検索されたユーザーのメールアドレスが正しいこと');

        // 該当するユーザーが存在しない場合
        $result = getUserInfo('NonExisting User', '', 0);
        $this->assertEmpty($result, '該当するユーザーが存在しない場合、結果が空であること');
    }
}
