require 'sass'
require 'sass/plugin'

# Allows external CSS files to be inlined with @import directives
class CSSImporter < Sass::Importers::Filesystem
  def extensions
    super.merge('css' => :scss)
  end
end
Sass::Plugin.options[:filesystem_importer] = CSSImporter
