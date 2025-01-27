{ pkgs, lib, config, inputs, ... }:

{
  # https://devenv.sh/basics/
  dotenv.enable = true;

  # https://devenv.sh/packages/
  packages = [ pkgs.git ];

  # https://devenv.sh/languages/
  # languages.rust.enable = true;
    languages.php.enable = true;
    languages.php.version = "8.3";
#    languages.php.package = pkgs.php.buildEnv {
#      extensions = { all, enabled }: with all; enabled ++ [ xdebug mysql ];
#      extraConfig = ''
#        xdebug.mode = debug
#        xdebug.discover_client_host = 1
#        xdebug.client_host = 127.0.0.1
#      '';
#    };
    languages.php.extensions = [ "xdebug" "pdo_mysql" ];
    languages.php.ini = ''xdebug.mode = debug
        xdebug.discover_client_host = 1
        xdebug.client_host = 127.0.0.1
    '';
    languages.javascript.enable = true;
    languages.javascript.package = pkgs.nodejs_20;
  # https://devenv.sh/processes/
  # processes.cargo-watch.exec = "cargo-watch";

  # https://devenv.sh/services/
  # services.postgres.enable = true;
    services.mysql.enable = true;
    services.mysql.ensureUsers = [
        {
            name = config.env.DB_USERNAME;
            password = config.env.DB_PASSWORD;
            ensurePermissions = {
              "${config.env.DB_DATABASE}.*" = "ALL PRIVILEGES";
            };
        }
    ];
  # https://devenv.sh/scripts/
#  scripts.hello.exec = ''
#    echo hello from $GREET
#  '';

#  enterShell = ''
#    hello
#    git --version
#  '';

  # https://devenv.sh/tests/
#  enterTest = ''
#    echo "Running tests"
#    git --version | grep --color=auto "${pkgs.git.version}"
#  '';

  # https://devenv.sh/pre-commit-hooks/
  # pre-commit.hooks.shellcheck.enable = true;

  # See full reference at https://devenv.sh/reference/options/
}
