
import { test, expect } from '@playwright/test';

test('halaman login Laravel bisa dibuka', async ({ page }) => {
    const response = await page.goto('http://127.0.0.1:8001/login');

    expect(response).not.toBeNull();
    expect(response.status()).toBe(200);
    await expect(page.locator('body')).not.toBeEmpty();
});
