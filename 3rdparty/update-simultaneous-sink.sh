Other than with paprefs we can manually combine sinks for playback. This may also be needed in case we had more than two sinks but only need some of them to be combined.

    Find out the names of available sinks

    pacmd list-sinks

    Combine two sinks

    pacmd load-module module-combine-sink sink_name=combine sink_properties=device.description=myCombine slaves=sink1,sink2[,...] channels=2
