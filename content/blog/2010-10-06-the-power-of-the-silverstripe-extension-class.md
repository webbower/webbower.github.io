---
layout: post
title: "The Power of the SilverStripe Extension Class"
date: 2010-10-06 18:25
comments: false
tags: [SilverStripe, PHP, Design Patterns]
intro: Extend nearly any core class in SilverStripe using the Extension class: add a special route handler to a module controller; add an email obfuscation output to string-based DBFields; add a watermarking output method to the core Image class. The possibilities are endless.
---

SilverStripe has some amazing ways to add functionality to the core code without hacking it. The way they have intelligently set up the class inheritance is fantastic. [MVC](http://en.wikipedia.org/wiki/Model–view–controller "Model/View/Controller") is pretty standard these days and shines in SilverStripe. And it also supports the the [Decorator pattern](http://en.wikipedia.org/wiki/Decorator_pattern).

## The Decorator Pattern.

It works a little different than traditional class inheritance in PHP and more closely resembles mixins from Ruby. Basically, instead of creating a subclass that directly inherits from its parent class, a Decorator allows you to roll a bit of functionality into its own class and apply it to any number of other classes, no matter what they're ancestry is. For example, in the context of SilverStripe, I have a few different page types:

* Blog Entry
* Blog Holder
* Portfolio Page
* Photo Gallery Page
* Staff Listing Page
* Staff Detail Page

All of them inherit directly from Page. I want to add a slideshow to my Blog Entries, Portfolios, and Photo Galleries. I could go 1 of 3 courses:

1. Add the slideshow functionality to Page and it will trickle down to all its children. Problem is, I don't need the extra tab in the getCMSFields() method for the Blog Holder or the Staff pages.
1. I add the functionality into the code for the 3 page types I want it to show up on. But that's not very [DRY](http://en.wikipedia.org/wiki/Don't_repeat_yourself "Don't Repeat Yourself"). If I want to make changes to how the slideshow works, I'd have to make the changes 3 times. Maintenance nightmare.
1. I create a Decorator with the DataObjectDecorator and using the Object::add_extension() or DataObject::add_extension() methods (and for the record, they're both referring to the same method since DataObject inherits from Object), I apply my slideshow functionality to the 3 pages types I want.

If you've been following along, option 3 is the best answer. I'm not going to give a tutorial about how to write one as that's somewhat covered on the docs page for the [DataObjectDecorator class](http://doc.silverstripe.org/dataobjectdecorator). I'm just bringing everyone up to speed on what the Decorator pattern is.

I had never heard about the Decorator pattern until working with SilverStripe and it seemed to me to live mostly in the DataObjectDocrator class. The DOD class brings us great functionality like Hierarchy (parent-child relationships, powers the SiteTree), Versioning, Translatable pages, Static Publising, and more. However, the parent class of DOD, is the Extension class (I'd provide a link but there isn't a page for it in the SS Docs) gets far less love. I plan to change that by making Extension the celbrity it deserves to be.

A quick overview: The DataObjectDecorator class is specifically designed to Decorate DataObjects and their children. It's a subclass of Extension with special functionality tailored to DataObjects. The Extension class can be applied to any class that inherits from the Object class, which is the base class for a majority of the SilverStripe classes.

## So, what can you do with this poor forgotten child called Extension?

I'm glad you asked.

Let's revisit something from the last (big) paragraph.

> The Extension class can be applied to any class that inherits from the Object class, which is the base class for a majority of the SilverStripe classes.

So, how might this be useful? The Controller classes inherit from Object. The DBField classes like Text, Varchar, Int, etc all inherit from Object. The GD class which allows us to crop, pad, and resize our images inherits from Object. That means we can add functionality to all of those and more. One quick Caveat on that: you can ADD functionality in the form of new methods, but you can't overwrite existing methods on the class you're extending. Oh, and did I forget to mention you can add as many Decorators (DataObjectDecorators and Extensions) to a class as you want? Ya! Awesomeness!

Allow me to present a few examples.

### Extending Controllers

Not happy with a template method on one of the Controller classes in a module? Subclass Extension, write yourself a new template method, apply the Extension, and call the new method in your template.

Let's say we have a Module_Controller class that came with a module and it has an UploadForm method that outputs a form into our template, but there's something about it we don't like, maybe an extra field we don't want to show.

```php
class MyControllerExtension extends Extension {
    public function MyUploadForm() {
        $form = $this->owner->UploadForm();
        // Modify the form
        return $form;
    }
}

Object::add_extension('Module_Controller', 'MyControllerExtension');
```

And in your template:

```php
<h1>$Title</h1>

$Content

$MyUploadForm
```

Remember, we can't overwrite the UploadForm method from the exsiting Module_Controller clas so we have to create a new method. That doesn't mean we can't take the original code and tweak it to our needs rather than copy/pasting the original method and modifying what we want to.

### Extending DBFields

Just to clarify, the DBField classes are the ones like Enum, Varchar, HTMLText, etc that you declare in the $db property of your Pages and DataObjects. Early in my days with SilverStripe, I wanted to add methods to some of the DBField classes to use in my templates. That was about 2 years ago and now I know how to. One major method I wanted to add was the ability to obfuscate email addresses for Varchar fields on my Pages/DataObjects that stored email addresses. I even created and submitted a subclass of Varchar for the purpose of storing Emails and had special methods for processing email addresses in special ways. It got rejected. *sad face* So today I am happy to present to you the way to add obfuscation to Varchar for emails and a building block for extending DBFields.

```php
class VarcharExtension extends Extension {
    public function ObfuscateEmail() {
        return Email::obfuscate($this->owner->value, 'hex');
    }
}

Object::add_extension('Varchar', 'VarcharExtension');
```

And in your template:

```php
$Email.ObfuscateEmail
```

The template code will output an obfuscated email address using the Email class's built-in functionality.

### Extending GD

GD is what allows us to prevent site maintainers and visitors from uploading images that break our layout. It's extremely powerful, but very simply written. The major functionality it gives us is proportional resizing, padded resizing, and cropping. So what if you want to add the ability to apply watermarks? I've seen people subclass GD and I'm not quite sure how they make the whole system use the GD subclass. Now, I can't really give an example here because, I'm not great with image editing in code using raw PHP functions and I haven't tested this theory to be absolutely sure, but in theory, you could create something like this:

```php
class Watermark extends Extension {
    public function addWatermark() {
        $gd = $this->owner->gd;
        // Run code to apply the watermark
        return $newGD;
    }
}

Object::add_extension('GD', 'Watermark');
```

And in your Image subclass:

```php
class WatermarkedImage extends Image {
    public function generateWatermarkedImage($gd) {
        return $gd->addWatermark();
    }
}
```

... and then refer to it in your template.

## Nifty, ain't it?

So there you have some examples of what can be done with the soft-spoken parent of the DataObjectDecorator class. I hope this gets your minds going to come up with some awesome ideas and save you from hacking the core or subclassing when you don't need to.