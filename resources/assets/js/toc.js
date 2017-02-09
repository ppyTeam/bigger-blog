const setOptions = (options = { }) => {
    /*
     * max_depth: Max depth of heading
     * depth: Depth of top heading
     * class: Class name
     * el: Element id for looking for
     */
    options.max_depth = options.hasOwnProperty('max_depth') ? options.max_depth : 6;
    options.depth = options.hasOwnProperty('depth') ? options.depth : 3;
    options.class = options.hasOwnProperty('class') ? options.class : 'toc';
    options.el = options.hasOwnProperty('el') ? options.el : 'content';

    return options;
};

let num = 0;

const idGenerator = id => {
    return (() => {
        if (id) return id;

        return 'post' + num++;
    })();
};


export default {
    tocGenerator (content, options) {

        // Convert String to Node
        if (typeof content === 'string') {
            let box = document.createElement('div');
            let div = document.createElement('div');
            box.appendChild(div);
            div.innerHTML = content;
            content = box.childNodes[0];
        }


        let headingsMaxDepth = options.max_depth,
            headingsSelector = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'].slice(0, headingsMaxDepth).join(','),
            headings = content.querySelectorAll(headingsSelector);

        if (!headings.length) return '';


        let headingsDepth = options.depth;


        let className = options.class,
            lastLevel = 0,
            depth = 0,
            depthArr = [],
            result = '<ol class="' + className + '">';

        Array.prototype.forEach.call(headings, node => {
            let tagName = node.tagName;
            let level = parseInt(tagName.replace('H', '')),
                id = idGenerator(node.getAttribute('id')),
                text = node.innerText;


            if (depth) {


                if (level > lastLevel) {
                    if (depth === headingsDepth) return;
                    result += '<ol class="' + className + '-child">';
                    depth++;
                    depthArr.push(level);
                }
                else if (level < lastLevel) {
                    let a = depth;
                    let b = depthArr.indexOf(level) === -1 ? 1 : depthArr.indexOf(level) + 1;
                    for (let i = b; i < a; i++) {
                        result += '</li></ol>';
                        depth--;
                        depthArr.pop();
                    }
                }
                else {
                    result += '</li>';
                }
            }
            else {
                depth++;
                depthArr.push(level);
            }

            result += '<li class="' + className + '-item ' + className + '-level-' + level + '">';
            result += '<a class="' + className + '-link" href="#' + id + '"><span class="' + className + '-text">' + text + '</span></a>';

            lastLevel = level;
        });

        for (let i = 0; i < depth; i++) {
            result += '</li></ol>';
        }

        return result;

    },

    tocAuto (options) {
        options = setOptions(options);

        const el = document.getElementById(options.el);

        if (!el) return;

        let content = el.innerHTML;
        el.innerHTML = this.tocGenerator(content, options) + content;
    },

    tocBlock (content, options) {
        options = setOptions(options);

        return this.tocGenerator(content, options);
    }
}