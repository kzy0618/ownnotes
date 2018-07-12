(function (OC, window, $, undefined) {
'use strict';

$(document).ready(function () {

let translations = {
    newNote: $('#new-note-string').text()
};

// this notes object holds all our notes
let Notes = function (baseUrl) {
    this._baseUrl = baseUrl;
    this._notes = [];
    this._activeNote = undefined;
};

Notes.prototype = {
    load: function (id) {
        let self = this;
        this._notes.forEach(function (note) {
            if (note.id === id) {
                note.active = true;
                self._activeNote = note;
            } else {
                note.active = false;
            }
        });
    },
    getActive: function () {
        return this._activeNote;
    },
    removeActive: function () {
        let index;
        let deferred = $.Deferred();
        let id = this._activeNote.id;
        this._notes.forEach(function (note, counter) {
            if (note.id === id) {
                index = counter;
            }
        });

        if (index !== undefined) {
            // delete cached active note if necessary
            if (this._activeNote === this._notes[index]) {
                delete this._activeNote;
            }

            this._notes.splice(index, 1);

            $.ajax({
                url: this._baseUrl + '/' + id,
                method: 'DELETE'
            }).done(function () {
                deferred.resolve();
            }).fail(function () {
                deferred.reject();
            });
        } else {
            deferred.reject();
        }
        return deferred.promise();
    },
    create: function (note) {
        let deferred = $.Deferred();
        let self = this;
        $.ajax({
            url: this._baseUrl,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(note)
        }).done(function (note) {
            self._notes.push(note);
            self._activeNote = note;
            self.load(note.id);
            deferred.resolve();
        }).fail(function () {
            deferred.reject();
        });
        return deferred.promise();
    },
    getAll: function () {
        return this._notes;
    },
    loadAll: function () {
        let deferred = $.Deferred();
        let self = this;
        $.get(this._baseUrl).done(function (notes) {
            self._activeNote = undefined;
            self._notes = notes;
            deferred.resolve();
        }).fail(function () {
            deferred.reject();
        });
        return deferred.promise();
    },
    updateActive: function (title, content) {
        let note = this.getActive();
        note.title = title;
        note.content = content;

        return $.ajax({
            url: this._baseUrl + '/' + note.id,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(note)
        });
    }
};

// this will be the view that is used to update the html
let View = function (notes) {
    this._notes = notes;
};

View.prototype = {
    renderContent: function () {
        let source = $('#content-tpl').html();
        let template = Handlebars.compile(source);
        let html = template({note: this._notes.getActive()});

        $('#editor').html(html);

        // handle saves
        let textarea = $('#app-content textarea');
        let self = this;
        $('#app-content button').click(function () {
            let content = textarea.val();
            let title = content.split('\n')[0]; // first line is the title

            self._notes.updateActive(title, content).done(function () {
                self.render();
            }).fail(function () {
                alert('Could not update note, not found');
            });
        });
    },
    renderNavigation: function () {
        let source = $('#navigation-tpl').html();
        let template = Handlebars.compile(source);
        let html = template({notes: this._notes.getAll()});

        $('#app-navigation ul').html(html);

        // create a new note
        let self = this;
        $('#new-note').click(function () {
            let note = {
                title: translations.newNote,
                content: ''
            };

            self._notes.create(note).done(function() {
                self.render();
                $('#editor textarea').focus();
            }).fail(function () {
                alert('Could not create note');
            });
        });

        // show app menu
        $('#app-navigation .app-navigation-entry-utils-menu-button').click(function () {
            let entry = $(this).closest('.note');
            entry.find('.app-navigation-entry-menu').toggleClass('open');
        });

        // delete a note
        $('#app-navigation .note .delete').click(function () {
            let entry = $(this).closest('.note');
            entry.find('.app-navigation-entry-menu').removeClass('open');

            self._notes.removeActive().done(function () {
                self.render();
            }).fail(function () {
                alert('Could not delete note, not found');
            });
        });

        // load a note
        $('#app-navigation .note > a').click(function () {
            let id = parseInt($(this).parent().data('id'), 10);
            self._notes.load(id);
            self.render();
            $('#editor textarea').focus();
        });
    },
    render: function () {
        this.renderNavigation();
        this.renderContent();
    }
};

let notes = new Notes(OC.generateUrl('/apps/ownnotes/notes'));
let view = new View(notes);
notes.loadAll().done(function () {
    view.render();
}).fail(function () {
    alert('Could not load notes');
});

});

})(OC, window, jQuery);

