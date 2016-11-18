const phantomjs = require( 'phantomjs-prebuilt' )
const spawn = require( 'child_process' ).spawn
const fs = require( 'fs' );

fs.exists( process.env.WP_ERROR_LOG, ( exists ) => {
  if ( exists ) {
    fs.unlink( process.env.WP_ERROR_LOG, ( e ) => {
      if ( e ) throw e;
    } );
  }
} )

phantomjs.run(
  '--webdriver=4444',
  '--ignore-ssl-errors=yes',
  '--cookies-file=/tmp/webdriver_cookie.txt'
).then( program => {
  const behat = spawn(
    'vendor/bin/codecept',
    [
      "run",
      "acceptance",
      "--steps"
    ],
    {
      stdio: "inherit"
    }
  )
  behat.on( 'exit', ( code ) => {
    program.kill()
    process.exit( code );
  } )
} )
