Sym MarkItUp 2.0
================

[MarkItUp!][1] editor in the Symphony administration back end. The editor will attach itself to any Markdown or Markdown Extra textareas.

## Default Editor buttons include

H1, H2, H3, H4, H5, H6, **Bold**, _Italic_, ~~Strikethrough~~, unordered list, numbered list, Picture, Link, Block Quote, Code

## Choosing which elements to add to your textarea

As of version 2.0 you can choose which elements are visible to your textarea, when editing the section, this extension will plugin to every place where it sees a selectbox including `formatter` where the value is not none. A multiselect box is then added with options to choose the wanted elements.

## Adding Custom Elements & Functions

MarkItUp supports custom elements and functions, here is a quick quide to what you can add. For more options visit the [MarkItUp documentation][2].

This extension adds all the MarkItUp formatting options to your config file, making it easy for you to edit and override any necessary functions. 
Probably the most useful thing which one has is the `replaceWith` property. 
This basically adds a block where you can have replacable elements inserted by the User, the below is a standard link example.

	replaceWith:'![[![Alternative text]!]]([![URL:!:http://]!] "[![Title]!]")'

As opposed to the original MarkItUp, these values are asked in a modal with Symphony-like styling and by default all variables are input fields.
MarkItUp runs a regex and tries to find any content enclosed within `[![` and `]!]` tags, to generate inputs for these elements.

	[![FieldLabel]!]

	[![FieldLabel:!:placeholder]!]

### Select Boxes

To create a select box instead of an input field, instead of passing the placeholders pass the select options separated by a `|`

	[![FieldLabel:!:option1|option2|option3]!]

### Linking to Association Fields (requires Association UI)

At times you might want to embed content which is provided through another section, and is present in an Association Field, for example embedding an image through another section. 
Note whatever you do will have to be processes using an XSLT ninja technique but this allows users to link to that content in a simple way.

	[![FieldLabel:!:field-fieldid]!]

The below is a custom element which is fetching elements from field 5, it is also asking the user which position they would want the image to be aligned. 

> {name:\'Article Picture\', className:\'fa fa-image\', key:\'P\', replaceWith:\'<image id="[![Image:!:field-5]!]" align="[![Type:!:left|right|full]!]" />\'},

The result from an Association would always be the value of that association, thus the entry id, this can then be used in XSLT to replace the element with what it is actually representing.

### Classnames & Icons

All icons are currently using [Font Awesome][3] so adding new elements should be very simple, practically a matter of setting the corresponding font-icon class in the `className` property.

Please feel free to post issues in GitHub if you come across any :)

  [1]: http://markitup.jaysalvat.com/home/
  [2]: http://markitup.jaysalvat.com/documentation/
  [3]: http://fortawesome.github.io/Font-Awesome/