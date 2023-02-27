/**
 * @package     Extension for OpenCart: Multiedit extend-buttons.
 * @author      Roman Sha
 * @copyright   2022 © All Rights Reserved
 * @license     Commercial
 * @link        https://opencartforum.com/files/developer/678008-sha/?utm_medium=profilecpage
 * @version     0.0.1-alpha (file version 06.10.2022)
 */

class ExtendButtons {
    _container = document.getElementById('extend-buttons');
    _itemTemplate = document.getElementById('extend-button');

    _build(list) {
        this._container.append(...list.map(itemAttrs => {
            let itemNode = this._itemTemplate.content.cloneNode(true)

            return this._render(itemNode?.children?.[0], itemAttrs);
        }));
    }

    _render(itemNode, itemAttrs) {
        // sanitaze
        let {name, title, classButton, classChild, path} = itemAttrs;

        itemNode.setAttribute(
            'title', 
                title !== 'undefined'
                ? title
                    : name !== 'undefined' 
                    ? name
                        : ''
        )

        if (document?.classButton)
            itemNode.classList.add(classButton)

        if (itemNode?.children?.[0])
            itemNode.children[0].classList.add(classChild || 'fa-cogs')

        if (path !== 'undefined') // TODO sanitaze
            itemNode.setAttribute('onclick', 'locationHref("' + path + '")')

        return itemNode;
    }

    constructor(data) {
        this._build( data );
    }
}

// example init
// let extendbuttons = new ExtendButtons();