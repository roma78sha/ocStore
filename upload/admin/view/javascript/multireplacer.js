/**
 * @package		Extension for OpenCart: MultiReplacer.
 * @author		Roman Sha
 * @copyright	2022 © All Rights Reserved
 * @license		Commercial
 * @link		https://opencartforum.com/files/developer/678008-sha/?utm_medium=profilecpage
 * @version     0.0.1-alpha (file version 04.10.2022)
 */

class Multireplacer {
    _app = document.querySelector('#content');
    _table = document.querySelector('#replacer-list');
    _itemTemplate = document.querySelector('#item-search-and-replace');

    _append() {
        let templateNode = this?._itemTemplate?.content.cloneNode(true).children?.[0];

        if (!templateNode
            || !this?._table)
            return false;

        return this?._table.append(templateNode);
    }

    addTask(appData) {
        // this._append();
        appData.tasks.push( {
            liClass: 'new'
        } )
    }

    constructor(data) {
        const self = this

        let multireplacer = {
            tableClass: 'table table-striped table-bordered table-hover',
            addTask() {
                self.addTask(this)
            },
            delLastTask() {
                delete this.tasks.pop()
            }
        }

        multireplacer = Object.assign(multireplacer, data)

        multireplacer = Multicomponents(this._app, multireplacer)

        return multireplacer;

        console.log('class Multireplacer construct!')
    }
}
