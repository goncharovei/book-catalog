# Catalog of books.

This is a project that showcases my Frontend and Backend skills. For example, implementing an API and several public, private user pages.

Implementation details in the project's [Wiki](https://github.com/goncharovei/book-catalog/wiki).

## General concept of the project

Let's assume that there is a book catalog website (hereinafter referred to as the Catalog).

There are several publishing websites selling books that would like to see their books in the Catalog. At the same time, different publishing houses can sell the same books. Books can have several authors.

The Catalog has:
1. The public part - a book list page.
2. A page for the publisher's personal account.

What needs to be done?
1. Write a RESTful API (hereinafter referred to as the API) for publishing websites that will allow getting, adding, editing, and deleting books from the Catalog list.
2. Create interactive API documentation.
3. Implement page for the list, as well as a page for the publisher's personal account.

Special technical requirements.
- Store list of book authors in JSON.
- Cover the functionality and API of the catalog with tests.

## Design principles

Over the years of programming, I have come to the conclusion that the minimum result of my work should be **readable code**.

Readable code is a set of rules:
1. There should be no unclear constants.
2. Avoid using the If statement whenever possible.<br>
3. The Classes, methods, functions should be short and their names correspond to what they do.
4. Do not clutter the code with comments, attributes.
5. Controllers and models must be thin.
6. The interaction of models is transferred to the Service (Service Oriented Architecture).
7. Use class's arguments with the Dependency injection. 
8. Avoid using the New statement whenever possible.
9. The structure of project files should resemble the table of contents of a book.
10. There should be no mixing of different languages. 
11. When planning the implementation of functionality, also consider security, performance, and support.

And a set of principles:
- "Keep it simple, stupid".<br>
- "Don’t repeat yourself".<br>
- "You aren't going to need it".

Things like the PSR, Patterns, OOP, SOLID, GRASP help with implementing readable code.
<br><br>
Having a readable code base makes it cheaper to maintain and/or growth up a project, and if necessary, transition to any architecture, for example Modular, Microservice,  Domain-driven design.
