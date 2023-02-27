/**
 * @package     Extension for OpenCart: Multi hot keys.
 * @author      Roman Sha
 * @copyright   2022 © All Rights Reserved
 * @license     Commercial
 * @link        https://opencartforum.com/files/developer/678008-sha/?utm_medium=profilecpage
 * @version     0.0.1-alpha (file version 08.10.2022)
 */

document.addEventListener("DOMContentLoaded", function (event) {
    const multiHotKeys = {
        // 'querySelector', 'key'
        'a[onclick^=multiedit]': 'm',
        'test-error': 'error',
        'form#form-product thead input[type=checkbox]': 'a',
    }

    for (const selector in multiHotKeys) {
        let node = document.querySelector(selector)

        if (!node)
            continue

        node.accessKey = multiHotKeys[selector];
    }

    console.log('Can be used: hot keys!');
});
