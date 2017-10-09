---
layout: post
title: "The Benefits of Using a CMS for Your Clients"
date: 2011-01-25 20:50
comments: false
tags: [SilverStripe]
intro: A CMS can greatly simplify maintaining a website, primarily by abstracting away the technical underpinnings of the web. This is fantastic for the non-tech-savvy people who have to maintain a website and the login/navigate/edit experience has become fairly ubiquitous on the web. Since this has become familiar, it's much easier to teach than muddling with FTP and remote filesystems as well.
---

As a Web Developer (or Web Professional in general), it is my job to give my clients the best recommendation for how to build their site. The two main choices are:

* The static HTML version where, if the client wishes to make any updates to their website, they have to brave FTP to access their files, find the right one, then try to write even semi well-formed HTML so they don't leave a tag open or close one prematurely that horribly breaks the appearance of their website and you get a frantic call while you're cooking that time-sensitive roast requesting you drop everything you're doing to fix it this minute. Heaven forbid you use some PHP (or Server-Side Language of your choice) to reuse headers and footers across pages. That's 3 acronyms they have to understand.
* The dynamic, database driven website where all the content is stored in a database and output into template files, most commonly found in the form of a CMS.

## In the Beginning...

In my early days of professional web work, I built sites following the first methodology. It was my job to train the clients how to update their site and give them a primer on HTML. I even had the misfortune of trying to adapt a site to be maintainable with Adobe Contribute. For those who are unfamiliar with it, it's halfway between both the options I listed above. You edit the files in a Dreamweaver-like WYSIWYG window and can set up permissions for who can edit what through Contribute. Nifty idea but I only used it once, at the client's request, and I hope to never use it again.

## But I digress...

But the point of this post is to discuss option the second. Feel free to cite anything I say for your clients in convincing them to invest the extra money to get their site running on a CMS. It does take a little extra time (and therefore money up front) to set up a site on a CMS, but the benefits are so worth it. The points I make will apply to most or all CMS's (or should).

* No need for the client to learn how to log into a server with FTP and edit any code. In my opinion, this is the best reason. Everything happens in the web browser. For the static HTML option, the client will need, at minimum, an FTP program and a text editor program, even if it's NotePad. Most, if not all CMS's, use a WYSIWYG field for editing the body content of any page, product, blog post, etc and using one is similar to using MS Word which just about everyone knows how to use. These wonderful fields write the HTML behind the scenes and the most complicated thing to teach the the client is when to use different level headings. The rest of the information about the page is just filling in text fields and uploading files as necessary. So much easier.
* CMS's are scalable. This means that, by laying the proper groundwork, the site becomes much easier to manage as it grows and is also much easier to extend its features.
* CMS's are built on top of a lot of pre-written code. This means that there's a powerful toolset available to reduce time, and cost, for adding features to the website.
* With a CMS, you can enter bits of content once, like products in a store or job postings, and use them anywhere on your website or other websites. If you edit any of the original bit of content, like the description of a product or the title of a job posting, anywhere that content is being referenced will automatically update to reflect the change. Edit once, update everywhere. For example, if there's a store on the website and it showcases select products on various pages, rather than manually entering the product details on those pages, you select which products to show and if any product details changed, all the instances of the showcased products would automatically update.

[SilverStripe](http://www.silverstripe.org/) is my CMS of choice. I've [used many others](/blog/the-great-cms-roundup) but I find SilverStripe is great for websites small and large. Installing it is takes me 10 minutes and it's very portable between server environments. Adding and editing pages is so intuitive and it's so simple to create a couple custom page types that require an image or manage a collection of child page entries. And the framework it's built on is so powerful and easily extendable. One prominent member of the SilverStripe community developed a small (joke, I think) web app in under an hour with it (Uncle Cheese for those who know of him).

There are more technical reasons why SilverStripe is my CMS of choice, but this was meant for more laymen, non-tech-savvy types. So help me, I'll never build a static HTML website for a client ever again.